import pandas as pd
import logging
from typing import List, Dict, Any

logger = logging.getLogger(__name__)

# Reuse the rule-based sentiment classifier directly
class SimpleClassifier:
    POSITIVE = [
        'tốt', 'ổn', 'ngon', 'đẹp', 'tuyệt', 'ok', 'good', 'great', 'best',
        'excellent', 'amazing', 'wonderful', 'top', 'quality', 'recommend',
        'professional', 'reliable', 'trusted', 'affordable', 'popular',
        'trending', 'innovative', 'effective', 'successful', 'growth'
    ]
    NEGATIVE = [
        'tệ', 'dở', 'chán', 'xấu', 'lừa', 'giả', 'scam', 'fake', 'bad',
        'worst', 'terrible', 'fail', 'problem', 'issue', 'complaint',
        'poor', 'cheap', 'broken', 'wrong', 'expensive', 'overpriced'
    ]

    def classify_sentiment(self, text: str) -> str:
        text_lower = text.lower()
        pos = sum(1 for w in self.POSITIVE if w in text_lower)
        neg = sum(1 for w in self.NEGATIVE if w in text_lower)
        if pos > neg:
            return 'positive'
        elif neg > pos:
            return 'negative'
        return 'neutral'


class MarketResearchService:
    def __init__(self):
        self.classifier = SimpleClassifier()

    def analyze_market(self, raw_data: Dict[str, Any], product: Dict[str, Any]) -> Dict[str, Any]:
        """
        Main function to process raw market data.
        """
        logger.info(f"[MarketResearch.Python] Starting analysis for product: {product.get('name', 'N/A')}")
        logger.info(f"[MarketResearch.Python] raw_data keys: {list(raw_data.keys())}")
        logger.info(f"[MarketResearch.Python] trends_data count: {len(raw_data.get('trends_data', []))}")
        logger.info(f"[MarketResearch.Python] shopping_data count: {len(raw_data.get('shopping_data', []))}")
        logger.info(f"[MarketResearch.Python] search_results count: {len(raw_data.get('search_results', []))}")

        # Log samples
        trends_sample = raw_data.get('trends_data', [])[:3]
        shopping_sample = raw_data.get('shopping_data', [])[:2]
        logger.info(f"[MarketResearch.Python] trends_data sample: {trends_sample}")
        logger.info(f"[MarketResearch.Python] shopping_data sample: {shopping_sample}")

        trend_analysis = self._forecast_trend(raw_data.get('trends_data', []))

        competitors = []
        for c in product.get('competitors', []):
            if isinstance(c, dict):
                competitors.append(c.get('name', ''))
            elif isinstance(c, str):
                competitors.append(c)

        price_analysis = self._analyze_pricing(raw_data.get('shopping_data', []), competitors)

        sentiment_analysis = self._analyze_sentiment(
            raw_data.get('news_results', []),
            raw_data.get('search_results', [])
        )

        result = {
            "trend_analysis": trend_analysis,
            "price_analysis": price_analysis,
            "sentiment_analysis": sentiment_analysis,
            "market_size_estimate": self._estimate_market_size()
        }

        logger.info(f"[MarketResearch.Python] Final result summary: "
                    f"trend={trend_analysis.get('trend_direction')}, "
                    f"growth={trend_analysis.get('growth_rate_pct')}%, "
                    f"price_min={price_analysis.get('market_price_min')}, "
                    f"price_max={price_analysis.get('market_price_max')}, "
                    f"sentiment={sentiment_analysis.get('overall_sentiment')}")

        return result

    def _forecast_trend(self, trends_timeline: List[Dict[str, Any]]) -> Dict[str, Any]:
        empty_result = {
            'forecast_6m': [],
            'growth_rate_pct': 0,
            'trend_direction': 'stable',
            'seasonality_peaks': [],
            'historical_data': []
        }

        if not trends_timeline:
            logger.warning("[MarketResearch.Python] trends_timeline is empty, skipping Prophet forecast")
            return empty_result

        try:
            df = pd.DataFrame(trends_timeline)
            logger.info(f"[MarketResearch.Python] trends DataFrame columns: {df.columns.tolist()}")
            logger.info(f"[MarketResearch.Python] trends DataFrame head:\n{df.head(5).to_string()}")

            # Rename columns to Prophet format
            if 'date' in df.columns and 'value' in df.columns:
                df = df.rename(columns={'date': 'ds', 'value': 'y'})
            elif 'ds' not in df.columns:
                logger.error(f"[MarketResearch.Python] Unexpected columns: {df.columns.tolist()}")
                return empty_result

            df['y'] = pd.to_numeric(df['y'], errors='coerce')
            df = df.dropna(subset=['y'])
            df = df[df['y'] > 0]  # Remove zero-value rows
            df['ds'] = pd.to_datetime(df['ds'], format='%Y-%m', errors='coerce')
            df = df.dropna(subset=['ds'])

            logger.info(f"[MarketResearch.Python] Cleaned trends rows: {len(df)}")

            if len(df) < 5:
                logger.warning(f"[MarketResearch.Python] Not enough data for Prophet ({len(df)} rows), need >= 5")
                return {**empty_result, 'historical_data': trends_timeline}

            try:
                from prophet import Prophet
                model = Prophet(
                    seasonality_mode='multiplicative',
                    yearly_seasonality=True,
                    weekly_seasonality=False,
                    daily_seasonality=False
                )
                model.fit(df)

                future = model.make_future_dataframe(periods=6, freq='M')
                forecast = model.predict(future)

                forecast_6m_df = forecast[['ds', 'yhat', 'yhat_lower', 'yhat_upper']].tail(6)
                forecast_6m = []
                for _, row in forecast_6m_df.iterrows():
                    forecast_6m.append({
                        'month': row['ds'].strftime('%Y-%m'),
                        'predicted': round(float(row['yhat']), 2),
                        'lower': round(float(row['yhat_lower']), 2),
                        'upper': round(float(row['yhat_upper']), 2)
                    })

                # Proposed Growth rate: Compare predicted average (next 6m) vs historical average (last 12m)
                # This reveals where the market is going relative to where it has been recently.
                hist_12m = df.tail(12)
                avg_hist = float(hist_12m['y'].mean()) if not hist_12m.empty else 0
                avg_fore = float(forecast_6m_df['yhat'].mean()) if not forecast_6m_df.empty else 0
                
                if avg_hist > 0:
                    growth_rate = ((avg_fore - avg_hist) / avg_hist) * 100
                else:
                    # Fallback to last vs first if not enough recent data
                    first_val = float(df['y'].iloc[0])
                    last_val = float(df['y'].iloc[-1])
                    growth_rate = ((last_val - first_val) / first_val * 100) if first_val > 0 else 0

                direction = 'up' if growth_rate > 3 else ('down' if growth_rate < -3 else 'stable')

                historical_data = [
                    {'month': row['ds'].strftime('%Y-%m'), 'value': float(row['y'])}
                    for _, row in df.iterrows()
                ]

                logger.info(f"[MarketResearch.Python] Prophet forecast done: {len(forecast_6m)} future points, "
                            f"avg_hist_12m={avg_hist:.2f}, avg_fore_6m={avg_fore:.2f}, growth={growth_rate:.1f}%")

                return {
                    'forecast_6m': forecast_6m,
                    'growth_rate_pct': round(growth_rate, 2),
                    'trend_direction': direction,
                    'seasonality_peaks': self._detect_seasonality(forecast),
                    'historical_data': historical_data
                }

            except ImportError:
                logger.error("[MarketResearch.Python] Prophet not installed, falling back to linear trend")
                return self._linear_trend_fallback(df, trends_timeline)

        except Exception as e:
            logger.error(f"[MarketResearch.Python] Prophet forecast error: {e}", exc_info=True)
            return {**empty_result, 'historical_data': trends_timeline}

    def _linear_trend_fallback(self, df, trends_timeline):
        """Simple linear trend when Prophet is unavailable"""
        try:
            # Use average of last 6 months vs previous 6 months for more stability
            if len(df) >= 12:
                last_6 = df.tail(6)
                prev_6 = df.iloc[-12:-6]
                avg_last = last_6['y'].mean()
                avg_prev = prev_6['y'].mean()
                growth_rate = ((avg_last - avg_prev) / avg_prev * 100) if avg_prev > 0 else 0
            else:
                first_val = float(df['y'].iloc[0])
                last_val = float(df['y'].iloc[-1])
                growth_rate = ((last_val - first_val) / first_val * 100) if first_val > 0 else 0

            direction = 'up' if growth_rate > 3 else ('down' if growth_rate < -3 else 'stable')
            
            historical_data = [
                {'month': row['ds'].strftime('%Y-%m'), 'value': float(row['y'])}
                for _, row in df.iterrows()
            ]
            return {
                'forecast_6m': [],
                'growth_rate_pct': round(growth_rate, 2),
                'trend_direction': direction,
                'seasonality_peaks': [],
                'historical_data': historical_data
            }
        except Exception as e:
            logger.error(f"[MarketResearch.Python] Linear fallback error: {e}")
            return {'forecast_6m': [], 'growth_rate_pct': 0, 'trend_direction': 'stable', 'seasonality_peaks': [], 'historical_data': trends_timeline}

    def _detect_seasonality(self, forecast) -> List[str]:
        if 'yearly' in forecast.columns:
            forecast = forecast.copy()
            forecast['month'] = forecast['ds'].dt.month
            monthly = forecast.groupby('month')['yearly'].mean()
            top_months = monthly.nlargest(2).index.tolist()
            return [f"Tháng {m}" for m in top_months]
        return []

    def _analyze_pricing(self, shopping_data: List[Dict[str, Any]], competitor_names: List[str]) -> Dict[str, Any]:
        empty_result = {
            'market_price_min': 0,
            'market_price_max': 0,
            'market_price_avg': 0,
            'market_price_median': 0,
            'price_segments': {},
            'competitor_prices': []
        }

        if not shopping_data:
            logger.warning("[MarketResearch.Python] shopping_data is empty, skipping price analysis")
            return empty_result

        df = pd.DataFrame(shopping_data)
        logger.info(f"[MarketResearch.Python] shopping_data columns: {df.columns.tolist()}")
        logger.info(f"[MarketResearch.Python] shopping_data head:\n{df.head(3).to_string()}")

        # SerpApi Shopping uses 'extracted_price', fallback to 'price' string
        if 'extracted_price' in df.columns:
            df['price_num'] = pd.to_numeric(df['extracted_price'], errors='coerce')
        elif 'price' in df.columns:
            # If it's a currency string like "$10.00" or "₫100,000"
            df['price_num'] = df['price'].astype(str).str.replace(r'[^\d.]', '', regex=True)
            df['price_num'] = pd.to_numeric(df['price_num'], errors='coerce')
        else:
            logger.error(f"[MarketResearch.Python] No price column found. Columns: {df.columns.tolist()}")
            return empty_result

        df = df.dropna(subset=['price_num'])
        df = df[df['price_num'] > 0]

        logger.info(f"[MarketResearch.Python] Valid price rows: {len(df)}, sample: {df['price_num'].head(5).tolist()}")

        if len(df) == 0:
            logger.warning("[MarketResearch.Python] No valid prices after cleaning")
            return empty_result

        q33 = df['price_num'].quantile(0.33)
        q66 = df['price_num'].quantile(0.66)

        budget_df  = df[df['price_num'] < q33]
        mid_df     = df[(df['price_num'] >= q33) & (df['price_num'] < q66)]
        premium_df = df[df['price_num'] >= q66]

        result = {
            'market_price_min': round(float(df['price_num'].min()), 2),
            'market_price_max': round(float(df['price_num'].max()), 2),
            'market_price_avg': round(float(df['price_num'].mean()), 2),
            'market_price_median': round(float(df['price_num'].median()), 2),
            'price_segments': {
                'budget': {
                    'range': f"< {int(q33):,}",
                    'avg': round(float(budget_df['price_num'].mean()), 2) if len(budget_df) > 0 else 0,
                    'count': len(budget_df)
                },
                'mid_range': {
                    'range': f"{int(q33):,} - {int(q66):,}",
                    'avg': round(float(mid_df['price_num'].mean()), 2) if len(mid_df) > 0 else 0,
                    'count': len(mid_df)
                },
                'premium': {
                    'range': f">= {int(q66):,}",
                    'avg': round(float(premium_df['price_num'].mean()), 2) if len(premium_df) > 0 else 0,
                    'count': len(premium_df)
                }
            },
            'competitor_prices': self._extract_competitor_prices(df, competitor_names)
        }

        logger.info(f"[MarketResearch.Python] Price analysis: min={result['market_price_min']}, max={result['market_price_max']}, avg={result['market_price_avg']}")
        return result

    def _extract_competitor_prices(self, df: pd.DataFrame, competitor_names: List[str]) -> List[Dict[str, Any]]:
        if 'title' not in df.columns or not competitor_names:
            return []

        comps = []
        for name in competitor_names:
            if not name:
                continue
            comp_df = df[df['title'].str.contains(name, case=False, na=False)]
            if len(comp_df) > 0:
                comps.append({
                    'name': name,
                    'avg_price': round(float(comp_df['price_num'].mean()), 2),
                    'count': len(comp_df)
                })
        return comps

    def _analyze_sentiment(self, news_results: List[Dict], search_results: List[Dict]) -> Dict[str, Any]:
        texts = []
        for item in news_results + search_results:
            if 'title' in item:
                texts.append(item['title'])
            if 'snippet' in item:
                texts.append(item['snippet'])

        if not texts:
            logger.warning("[MarketResearch.Python] No text for sentiment analysis")
            return {
                'overall_sentiment': 'neutral',
                'sentiment_score': 0,
                'positive_count': 0,
                'neutral_count': 0,
                'negative_count': 0
            }

        pos_count = neg_count = neu_count = 0
        total_score = 0

        for text in texts:
            label = self.classifier.classify_sentiment(text)
            if label == 'positive':
                pos_count += 1
                total_score += 1
            elif label == 'negative':
                neg_count += 1
                total_score -= 1
            else:
                neu_count += 1

        total = len(texts)
        score = total_score / total if total > 0 else 0
        overall = 'positive' if score > 0.1 else ('negative' if score < -0.1 else 'neutral')

        logger.info(f"[MarketResearch.Python] Sentiment: {overall} (score={score:.2f}, pos={pos_count}, neu={neu_count}, neg={neg_count})")
        return {
            'overall_sentiment': overall,
            'sentiment_score': round(score, 2),
            'positive_count': pos_count,
            'neutral_count': neu_count,
            'negative_count': neg_count
        }

    def _estimate_market_size(self) -> Dict[str, Any]:
        return {
            "tam_vnd_billion": 0,
            "sam_vnd_billion": 0,
            "som_vnd_billion": 0,
            "growth_rate_annual_pct": 0,
            "note": "Cần dữ liệu nội bộ ngành để ước lượng chính xác."
        }
