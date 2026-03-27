import os
import json
import logging
import asyncio
from typing import List, Dict, Any, Optional
from bs4 import BeautifulSoup
from playwright.async_api import async_playwright
import chromadb
from serpapi import GoogleSearch
import google.generativeai as genai
import pandas as pd
from prophet import Prophet
from config.settings import settings

logger = logging.getLogger(__name__)

# Configure genai with settings or environment
def configure_gemini():
    api_key = settings.gemini_api_key or os.getenv("GEMINI_API_KEY")
    if api_key:
        genai.configure(api_key=api_key)
        logger.info("Gemini API configured successfully")
    else:
        logger.warning("Gemini API Key missing")

configure_gemini()

chroma_client = chromadb.PersistentClient(path="./chroma_db")

class ForecastService:
    def __init__(self):
        pass

    def generate_forecast(self, data: List[Dict[str, Any]], periods: int = 3) -> Dict[str, Any]:
        """
        data format: [{"ds": "2023-01-01", "y": 100}, ...]
        Returns predictions and trend components.
        """
        if not data:
            raise ValueError("No historical data provided for forecasting")
            
        df = pd.DataFrame(data)
        
        # Train Prophet model
        m = Prophet(yearly_seasonality=len(df) > 365, weekly_seasonality=True, daily_seasonality=False)
        m.fit(df)
        
        # Make future dataframe
        # Assuming monthly by default if not specified, let's use 'M' freq for typical business metrics
        # Could be configured via request
        future = m.make_future_dataframe(periods=periods, freq='M')
        forecast = m.predict(future)
        
        # Extract results
        result_df = forecast[['ds', 'yhat', 'yhat_lower', 'yhat_upper']].tail(periods)
        
        return {
            "forecast": json.loads(result_df.to_json(orient='records', date_format='iso')),
            "trend": "up" if forecast.iloc[-1]['yhat'] > forecast.iloc[0]['yhat'] else "down"
        }

class MarketResearchService:
    def __init__(self):
        self.serp_api_key = settings.serpapi_api_key if hasattr(settings, 'serpapi_api_key') else os.getenv("SERPAPI_API_KEY")
        self.collection = chroma_client.get_or_create_collection(name="market_research")

    async def get_serpapi_competitors(self, product_name: str, industry: str) -> List[Dict[str, str]]:
        if not self.serp_api_key:
            logger.warning("No SerpAPI key found")
            return []
            
        query = f"top {product_name} in {industry} market"
        params = {
            "q": query,
            "api_key": self.serp_api_key,
            "num": 5
        }
        
        try:
            search = GoogleSearch(params)
            results = search.get_dict()
            organic_results = results.get("organic_results", [])
            
            competitors = []
            for r in organic_results:
                link = r.get("link")
                title = r.get("title")
                if link and "wikipedia" not in link:
                    competitors.append({"name": title, "url": link})
            return competitors[:5]
        except Exception as e:
            logger.error(f"SerpAPI Error: {e}")
            return []

    async def scrape_competitor(self, url: str) -> str:
        """Use Playwright to scrape full text of a page"""
        if not url: return ""
        text_content = ""
        try:
            async with async_playwright() as p:
                browser = await p.chromium.launch(headless=True)
                page = await browser.new_page()
                await page.goto(url, timeout=30000, wait_until="networkidle")
                
                # Extract clean text
                html = await page.content()
                soup = BeautifulSoup(html, 'html.parser')
                
                # Remove scripts and styles
                for script in soup(["script", "style", "nav", "footer"]):
                    script.extract()
                    
                text = soup.get_text(separator=' ', strip=True)
                text_content = text[:5000] # Limiting size
                await browser.close()
        except Exception as e:
            logger.error(f"Scrape Error for {url}: {e}")
        return text_content

    async def summarize_with_gemini(self, query: str) -> str:
        """Query Gemini using the prompt provided with automatic model rotation"""
        # List of candidate models in order of preference
        target_models = ['gemini-2.0-flash-lite', 'gemini-2.0-flash', 'gemini-1.5-flash', 'gemini-flash-latest']
        
        last_error = ""
        for model_name in target_models:
            try:
                configure_gemini()
                logger.info(f"Attempting analysis with model: {model_name}")
                model = genai.GenerativeModel(model_name)
                response = model.generate_content(query)
                
                if response and response.text:
                    logger.info(f"Success with model: {model_name}")
                    return response.text
                
                last_error = "Empty response from AI."
            except Exception as e:
                last_error = str(e)
                logger.warning(f"Model {model_name} failed: {last_error}")
                # If quota exceeded (429) or model missing (404), try next
                if "429" in last_error or "404" in last_error:
                    continue
                else:
                    break

        return f"Unable to generate summary: {last_error}"

    async def conduct_full_research(self, request: Any) -> Dict[str, Any]:
        """Orchestrate the full market research pipeline"""
        all_competitors = []
        
        # 1. Use provided competitors
        if request.competitors:
            all_competitors.extend([{"name": c.name, "url": c.url} for c in request.competitors if c.url])
            
        # 2. Backfill with SerpAPI if needed
        if len(all_competitors) < 3:
            logger.info("Discovering competitors via SerpAPI")
            discovered = await self.get_serpapi_competitors(request.product_name, request.industry)
            all_competitors.extend(discovered)
            
        # Deduplicate
        unique_urls = set()
        final_competitors = []
        for c in all_competitors:
            if c['url'] not in unique_urls:
                unique_urls.add(c['url'])
                final_competitors.append(c)

        # 3. Scrape websites concurrently
        scrape_tasks = [self.scrape_competitor(c['url']) for c in final_competitors]
        results = await asyncio.gather(*scrape_tasks, return_exceptions=True)
        
        # 4. Save to ChromaDB & Create RAG Context
        context_parts = []
        for idx, text in enumerate(results):
            if isinstance(text, str) and text:
                comp = final_competitors[idx]
                doc_id = f"{request.product_id}_{comp['name']}"
                
                self.collection.add(
                    documents=[text],
                    metadatas=[{"source": comp['url'], "product_id": request.product_id}],
                    ids=[doc_id]
                )
                context_parts.append(f"Competitor: {comp['name']}\nData: {text[:1000]}")
                
        full_context = "\n\n".join(context_parts)
        
        # 5. Generate final report via Gemini
        prompt = f"{request.prompt_template}\n\nContext from web scraping:\n{full_context}"
        analysis = await self.summarize_with_gemini(prompt)
        
        return {
            "status": "success",
            "competitors_analyzed": final_competitors,
            "analysis_report": analysis
        }
