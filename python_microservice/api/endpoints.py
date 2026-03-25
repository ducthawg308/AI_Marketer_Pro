"""
API endpoints for the Comment Analysis Microservice.
"""
from typing import List, Dict
from fastapi import APIRouter, HTTPException, status
from fastapi.responses import JSONResponse
from fastapi import FastAPI

from models.schemas import (
    Comment, AnalysisResult, HealthCheck, 
    BatchAnalysisRequest, BatchAnalysisResponse
)
from services.classifier import CommentAnalysisService
from config.settings import settings
from datetime import datetime
import logging

logger = logging.getLogger(__name__)

# Create API router
router = APIRouter()

# Initialize service
analysis_service = CommentAnalysisService()

# Note: Main FastAPI app is created in main.py to avoid circular imports


@router.get("/", response_model=HealthCheck, tags=["Health"])
async def health_check():
    """Health check endpoint"""
    return HealthCheck(
        message="Comment Analysis Microservice is running",
        timestamp=datetime.now().isoformat(),
        version=settings.version,
        environment=settings.environment.value
    )


@router.post(
    "/analyze-comments", 
    response_model=List[AnalysisResult],
    tags=["Analysis"],
    summary="Analyze multiple comments",
    description="Analyze a batch of comments using rule-based classification"
)
async def analyze_comments(comments: List[Comment]):
    """Analyze multiple comments using rule-based classification"""
    try:
        results = analysis_service.analyze_batch_comments(comments)
        
        logger.info(f"Successfully analyzed {len(results)} comments")
        
        return results
        
    except Exception as e:
        logger.error(f"Error analyzing comments: {str(e)}")
        raise HTTPException(
            status_code=status.HTTP_500_INTERNAL_SERVER_ERROR,
            detail=f"Error analyzing comments: {str(e)}"
        )


@router.post(
    "/analyze-comments-facebook",
    response_model=List[AnalysisResult],
    tags=["Analysis"],
    summary="Analyze Facebook comments",
    description="Analyze Facebook API comment data using rule-based classification"
)
async def analyze_comments_facebook(comments: List[Dict]):
    """Analyze Facebook API comment data using rule-based classification"""
    try:
        results = analysis_service.analyze_facebook_comments(comments)
        
        logger.info(f"Successfully analyzed {len(results)} Facebook comments")
        
        return results
        
    except Exception as e:
        logger.error(f"Error analyzing Facebook comments: {str(e)}")
        raise HTTPException(
            status_code=status.HTTP_500_INTERNAL_SERVER_ERROR,
            detail=f"Error analyzing Facebook comments: {str(e)}"
        )


@router.post(
    "/analyze-comments-raw",
    response_model=List[AnalysisResult],
    tags=["Analysis"],
    summary="Analyze raw comment data",
    description="Analyze raw request data (supports both single dict and list of dicts)"
)
async def analyze_comments_raw(request: Dict):
    """Analyze Facebook API comment data using rule-based classification (raw dict)"""
    try:
        results = analysis_service.analyze_raw_request(request)
        
        logger.info(f"Successfully analyzed {len(results)} comments from raw request")
        
        return results
        
    except Exception as e:
        logger.error(f"Error analyzing raw comments: {str(e)}")
        raise HTTPException(
            status_code=status.HTTP_500_INTERNAL_SERVER_ERROR,
            detail=f"Error analyzing raw comments: {str(e)}"
        )


@router.post(
    "/analyze-comments-dict",
    response_model=List[AnalysisResult],
    tags=["Analysis"],
    summary="Analyze single comment dict",
    description="Analyze Facebook API comment data using rule-based classification (dict input)"
)
async def analyze_comments_dict(request: Dict):
    """Analyze Facebook API comment data using rule-based classification (dict input)"""
    try:
        results = analysis_service.analyze_raw_request(request)
        
        logger.info(f"Successfully analyzed 1 comment from dict request")
        
        return results
        
    except Exception as e:
        logger.error(f"Error analyzing dict comment: {str(e)}")
        raise HTTPException(
            status_code=status.HTTP_500_INTERNAL_SERVER_ERROR,
            detail=f"Error analyzing dict comment: {str(e)}"
        )


@router.post(
    "/analyze-batch",
    response_model=BatchAnalysisResponse,
    tags=["Analysis"],
    summary="Analyze batch of comments with metadata",
    description="Analyze a batch of comments and return results with processing metadata"
)
async def analyze_batch(request: BatchAnalysisRequest):
    """Analyze a batch of comments with detailed response"""
    try:
        results = analysis_service.analyze_batch_comments(request.comments)
        
        response = BatchAnalysisResponse(
            results=results,
            total_comments=len(results),
            processed_at=datetime.now().isoformat()
        )
        
        logger.info(f"Successfully processed batch of {len(results)} comments")
        
        return response
        
    except Exception as e:
        logger.error(f"Error analyzing batch comments: {str(e)}")
        raise HTTPException(
            status_code=status.HTTP_500_INTERNAL_SERVER_ERROR,
            detail=f"Error analyzing batch comments: {str(e)}"
        )


@router.get(
    "/metrics",
    tags=["Metrics"],
    summary="Get service metrics",
    description="Get basic service metrics and statistics"
)
async def get_metrics():
    """Get service metrics"""
    return {
        "service": settings.app_name,
        "version": settings.version,
        "environment": settings.environment.value,
        "status": "healthy",
        "timestamp": datetime.now().isoformat()
    }


@router.get(
    "/patterns",
    tags=["Configuration"],
    summary="Get classification patterns",
    description="Get the regex patterns used for comment classification"
)
async def get_patterns():
    """Get the classification patterns used by the service"""
    return {
        "price_patterns": analysis_service.classifier.price_patterns,
        "spam_patterns": analysis_service.classifier.spam_patterns,
        "negative_patterns": analysis_service.classifier.negative_patterns,
        "positive_patterns": analysis_service.classifier.positive_patterns,
        "configuration": {
            "min_message_length": settings.min_message_length,
            "confidence_threshold": settings.classification_confidence_threshold
        }
    }


# Backward compatibility endpoints (without /api/v1 prefix)
@router.post("/analyze-comments", response_model=List[AnalysisResult], tags=["Legacy"])
async def analyze_comments_legacy(comments: List[Comment]):
    """Legacy endpoint for backward compatibility"""
    return await analyze_comments(comments)

@router.post("/analyze-comments-facebook", response_model=List[AnalysisResult], tags=["Legacy"])
async def analyze_comments_facebook_legacy(comments: List[Dict]):
    """Legacy endpoint for backward compatibility"""
    return await analyze_comments_facebook(comments)

@router.post("/analyze-comments-raw", response_model=List[AnalysisResult], tags=["Legacy"])
async def analyze_comments_raw_legacy(request: Dict):
    """Legacy endpoint for backward compatibility"""
    return await analyze_comments_raw(request)

@router.post("/analyze-comments-dict", response_model=List[AnalysisResult], tags=["Legacy"])
async def analyze_comments_dict_legacy(request: Dict):
    """Legacy endpoint for backward compatibility"""
    return await analyze_comments_dict(request)
