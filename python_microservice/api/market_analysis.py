from fastapi import APIRouter, HTTPException, BackgroundTasks
from pydantic import BaseModel
from typing import List, Dict, Optional, Any
import logging

router = APIRouter()
logger = logging.getLogger(__name__)

class Competitor(BaseModel):
    name: Optional[str] = None
    url: Optional[str] = None

class ResearchRequest(BaseModel):
    product_id: int
    product_name: str
    industry: str
    description: Optional[str] = ""
    research_type: str
    start_date: str
    end_date: str
    competitors: Optional[List[Competitor]] = []
    prompt_template: str
    
class ForecastRequest(BaseModel):
    data: List[Dict[str, Any]]
    periods: int = 3

@router.post("/forecast")
async def predict_forecast(request: ForecastRequest):
    """Predicts future trends using Prophet"""
    try:
        from services.market_intelligence import ForecastService
        service = ForecastService()
        return service.generate_forecast(request.data, request.periods)
    except Exception as e:
        logger.error(f"Prophet forecast error: {e}")
        return {"error": str(e), "fallback_method": "php"}

@router.post("/research")
async def conduct_research(request: ResearchRequest, background_tasks: BackgroundTasks):
    """
    Main endpoint for Deep Market Intelligence (Method 2).
    This performs SerpAPI search, Web Scraping (Playwright), 
    inserts into ChromaDB, and uses Gemini to synthesize the report.
    """
    try:
        from services.market_intelligence import MarketResearchService
        service = MarketResearchService()
        result = await service.conduct_full_research(request)
        return result
    except Exception as e:
        logger.error(f"Market research error: {e}")
        raise HTTPException(status_code=500, detail=str(e))
