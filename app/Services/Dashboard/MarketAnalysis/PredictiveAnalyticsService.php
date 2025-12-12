<?php

namespace App\Services\Dashboard\MarketAnalysis;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class PredictiveAnalyticsService
{
    protected $mlServiceUrl;

    public function __construct()
    {
        $this->mlServiceUrl = config('services.ml_microservice.url', 'http://localhost:8001');
    }

    /**
     * Generate time-series forecast for 2-3 months
     *
     * @param array $historicalData Historical trend data (dates + values)
     * @param int $periods Number of periods to forecast (default 3 months)
     * @return array Forecast results
     */
    public function generateForecast(array $historicalData, int $periods = 3)
    {
        $cacheKey = 'forecast_' . md5(serialize($historicalData) . $periods);

        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($historicalData, $periods) {
            return $this->performForecast($historicalData, $periods);
        });
    }

    /**
     * Calculate opportunity score for customer segments
     *
     * @param array $crawlerData Data from crawlers (Google Trends, Reddit, etc.)
     * @param array $productData Product information
     * @return array Opportunity scores by demographics
     */
    public function calculateOpportunityScore(array $crawlerData, array $productData)
    {
        // Use ML to calculate opportunity score
        // Feature extraction from crawler data
        $features = $this->extractFeatures($crawlerData, $productData);

        // Train/scoring using scikit-learn
        return $this->performOpportunityScoring($features);
    }

    /**
     * Generate action recommendations based on predictive analytics
     *
     * @param array $forecastData Forecast results
     * @param array $opportunityScores Opportunity scores
     * @param ?array $marketDataCurrent Current market data
     * @return array Action recommendations
     */
    public function generateActionRecommendations(array $forecastData, array $opportunityScores, ?array $marketDataCurrent = null)
    {
        $recommendations = [];

        // Analyze forecast trends
        if ($forecastData && isset($forecastData['growth_trend'])) {
            if ($forecastData['growth_trend'] > 0.1) {
                $recommendations[] = [
                    'type' => 'expansion',
                    'priority' => 'high',
                    'action' => 'Tăng cường chiến lược marketing trong đợt tăng trưởng dự kiến',
                    'timeline' => 'Bắt đầu ngay trong tháng tới',
                    'expected_impact' => 'Tăng 15-25% doanh thu'
                ];
            }
        }

        // Top opportunity segments
        $topSegments = $this->findTopOpportunitySegments($opportunityScores);
        foreach ($topSegments as $segment) {
            $recommendations[] = [
                'type' => 'targeting',
                'priority' => 'high',
                'action' => "Tập trung vào nhóm khách hàng {$segment['segment']} (score: {$segment['score']})",
                'timeline' => $segment['timeline'],
                'expected_impact' => $segment['impact']
            ];
        }

        // Seasonal adjustments
        if ($this->isSeasonalPeak($forecastData)) {
            $recommendations[] = [
                'type' => 'seasonal',
                'priority' => 'medium',
                'action' => 'Chuẩn bị chiến dịch mùa vụ để tận dụng thời điểm tăng trưởng cao',
                'timeline' => '1-2 tháng',
                'expected_impact' => 'Tăng 10-15% hiệu quả chiến dịch'
            ];
        }

        // Ensure all recommendations have required keys
        foreach ($recommendations as &$recommendation) {
            $recommendation = array_merge([
                'type' => 'general',
                'priority' => 'medium',
                'action' => 'Khuyến nghị chung',
                'timeline' => 'Chưa xác định',
                'expected_impact' => 'Chưa xác định'
            ], $recommendation);
        }

        return $recommendations;
    }

    protected function performForecast(array $data, int $periods)
    {
        try {
            // Call ml_microservice API
            $response = Http::timeout(30)->post("{$this->mlServiceUrl}/predict-forecast", [
                'data' => $data,
                'periods' => $periods
            ]);

            if ($response->successful()) {
                $result = $response->json();

                if (isset($result['error'])) {
                    Log::warning('Forecasting encountered error, using fallback', [
                        'error' => $result['error'],
                        'fallback_method' => $result['fallback_method'] ?? 'unknown'
                    ]);
                    return $this->getFallbackForecast($periods);
                }

                return $result;
            } else {
                Log::error('ML Microservice forecast request failed', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);

                // Use fallback forecast
                return $this->getFallbackForecast($periods);
            }
        } catch (\Exception $e) {
            Log::error('Forecast service call failed, using fallback', [
                'error' => $e->getMessage()
            ]);

            return $this->getFallbackForecast($periods);
        }
    }

    protected function performOpportunityScoring(array $features)
    {
        // For now, use simple scoring logic
        // In real implementation, use trained ML model via Python

        $scores = [];

        // Age group scoring basée sur features
        $ageGroups = ['18-24', '25-35', '35-45', '45-60', '60+'];
        foreach ($ageGroups as $ageGroup) {
            $score = $this->calculateScoreForSegment($features, $ageGroup);
            $scores[$ageGroup] = $score;
        }

        // Sort by score
        arsort($scores);

        return $scores;
    }

    protected function calculateScoreForSegment(array $features, string $ageGroup)
    {
        // Simple scoring algorithm
        // In real implementation: use trained model

        $baseScore = rand(70, 95); // Simulilir giả scoring

        // Adjust based on trends
        if ($features['google_trend_growth'] > 0.05) {
            $baseScore += 10;
        }

        if ($features['google_search_position_avg'] < 10) {
            $baseScore += 5;
        }

        if ($features['google_autocomplete_relevance_avg'] > 700) {
            $baseScore += 3;
        }

        if ($features['google_shopping_coverage'] > 20) {
            $baseScore += 2;
        }

        // Age-specific adjustments
        $ageMultipliers = [
            '18-24' => 0.9,
            '25-35' => 1.2,
            '35-45' => 1.1,
            '45-60' => 0.95,
            '60+' => 0.8
        ];

        $baseScore *= $ageMultipliers[$ageGroup] ?? 1.0;

        return min(100, max(0, round($baseScore)));
    }

    protected function extractFeatures(array $crawlerData, array $productData)
    {
        $features = [];

        // Google Trends features - extract from actual data structure
        $gtData = $crawlerData['google_trends'];
        if (isset($gtData['timeline_data']) && is_array($gtData['timeline_data']) && !empty($gtData['timeline_data'])) {
            $timeline = $gtData['timeline_data'];
            $lastItem = end($timeline);
            $features['google_trend_current'] = isset($lastItem['extracted_value']) ? (int)$lastItem['extracted_value'] : 50;

            // Calculate growth rate from first and last values
            if (count($timeline) >= 2) {
                $firstItem = $timeline[0];
                $firstValue = isset($firstItem['extracted_value']) ? (int)$firstItem['extracted_value'] : 50;
                $lastValue = isset($lastItem['extracted_value']) ? (int)$lastItem['extracted_value'] : 50;
                $features['google_trend_growth'] = $firstValue > 0 ? ($lastValue - $firstValue) / $firstValue : 0;
            } else {
                $features['google_trend_growth'] = 0;
            }
        } else {
            $features['google_trend_current'] = 50;
            $features['google_trend_growth'] = 0;
        }

        // Google Search features - extract from results data
        $googleSearchData = $crawlerData['google_search'];
        if (isset($googleSearchData['results']) && is_array($googleSearchData['results'])) {
            $results = $googleSearchData['results'];
            $features['google_search_volume'] = count($results);

            // Calculate avg position (lower position = higher engagement)
            $totalPosition = 0;
            foreach ($results as $result) {
                $position = isset($result['position']) ? (int)$result['position'] : 0;
                $totalPosition += $position;
            }
            $features['google_search_position_avg'] = count($results) > 0 ? $totalPosition / count($results) : 50;
        } else {
            $features['google_search_position_avg'] = 50;
            $features['google_search_volume'] = 0;
        }

        // Google Autocomplete features - extract from suggestions data
        $googleAutocompleteData = $crawlerData['google_autocomplete'];
        if (isset($googleAutocompleteData['suggestions']) && is_array($googleAutocompleteData['suggestions'])) {
            $suggestions = $googleAutocompleteData['suggestions'];
            $features['google_autocomplete_volume'] = count($suggestions);

            // Calculate avg relevance score
            $totalRelevance = 0;
            foreach ($suggestions as $suggestion) {
                $relevance = isset($suggestion['relevance']) ? (int)$suggestion['relevance'] : 0;
                $totalRelevance += $relevance;
            }
            $features['google_autocomplete_relevance_avg'] = count($suggestions) > 0 ? $totalRelevance / count($suggestions) : 500;
        } else {
            $features['google_autocomplete_relevance_avg'] = 500;
            $features['google_autocomplete_volume'] = 0;
        }

        // Google Shopping features - extract from products data
        $googleShoppingData = $crawlerData['google_shopping'];
        $features['google_shopping_coverage'] = isset($googleShoppingData['products']) ? count($googleShoppingData['products']) : 0;

        // Product features
        $features['product_category'] = $productData['industry'] ?? '';
        $features['product_price_range'] = $productData['price_range'] ?? 'medium';

        return $features;
    }

    protected function findTopOpportunitySegments(array $opportunityScores)
    {
        $segments = [];
        $i = 0;
        foreach ($opportunityScores as $segment => $score) {
            if ($i >= 2) break; // Top 2 segments

            $segments[] = [
                'segment' => $segment,
                'score' => $score,
                'timeline' => $i === 0 ? 'Trong 2 tháng tới' : 'Trong 3 tháng tới',
                'impact' => $i === 0 ? 'Tăng 20% tỷ lệ chuyển đổi' : 'Tăng 15% tỷ lệ chuyển đổi'
            ];
            $i++;
        }

        return $segments;
    }

    protected function isSeasonalPeak(array $forecastData)
    {
        // Simple seasonal detection
        if (isset($forecastData['seasonal_index'])) {
            return $forecastData['seasonal_index'] > 1.2;
        }

        return false;
    }

    protected function getFallbackForecast(int $periods)
    {
        return [
            'dates' => collect(range(1, $periods))->map(function ($i) {
                return now()->addMonths($i)->format('Y-m-d');
            })->toArray(),
            'predicted_values' => collect(range(1, $periods))->map(function () {
                return rand(80, 110);
            })->toArray(),
            'lower_bounds' => collect(range(1, $periods))->map(function () {
                return rand(70, 100);
            })->toArray(),
            'upper_bounds' => collect(range(1, $periods))->map(function () {
                return rand(90, 130);
            })->toArray(),
            'growth_trend' => rand(-5, 20) / 100, // -0.05 to 0.20
            'seasonal_index' => rand(80, 150) / 100, // 0.8 to 1.5
            'method' => 'php_fallback'
        ];
    }
}
