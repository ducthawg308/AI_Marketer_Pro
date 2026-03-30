"""
Main application entry point for the Comment Analysis Microservice.
"""
import sys
from contextlib import asynccontextmanager
from typing import AsyncGenerator

from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from fastapi.middleware.trustedhost import TrustedHostMiddleware
from starlette.middleware.base import BaseHTTPMiddleware
from starlette.requests import Request
from starlette.responses import Response

import sys
import os
sys.path.append(os.path.dirname(os.path.abspath(__file__)))

from config.settings import settings
from api.endpoints import router


@asynccontextmanager
async def lifespan(app: FastAPI) -> AsyncGenerator[None, None]:
    """Application lifespan events"""
    # Startup
    yield
    
    # Shutdown


# Create FastAPI app with lifespan
app = FastAPI(
    title=settings.app_name,
    version=settings.version,
    description="Microservice for analyzing Facebook comments using rule-based classification",
    docs_url="/docs" if settings.is_development else None,
    redoc_url="/redoc" if settings.is_development else None,
    openapi_url="/openapi.json" if settings.is_development else None,
    lifespan=lifespan
)


# Add middleware
class LoggingMiddleware(BaseHTTPMiddleware):
    """Middleware to log all requests"""
    async def dispatch(self, request: Request, call_next):
        # Process request
        response = await call_next(request)
        
        return response


# Add middleware to app
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"] if settings.is_development else [],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

app.add_middleware(
    TrustedHostMiddleware,
    allowed_hosts=["localhost", "127.0.0.1", "*"] if settings.is_development else ["localhost", "127.0.0.1"]
)

app.add_middleware(LoggingMiddleware)


# Include API routes from endpoints module
from api.endpoints import router
app.include_router(router, prefix="/api/v1")


# Add backward compatibility endpoints directly to main app
from services.classifier import CommentAnalysisService
from models.schemas import Comment
from fastapi import HTTPException, status

analysis_service = CommentAnalysisService()

@app.post("/analyze-comments", response_model=list, tags=["Legacy"])
async def analyze_comments_legacy(comments: list):
    """Legacy endpoint for backward compatibility"""
    try:
        results = analysis_service.analyze_batch_comments(comments)
        return results
    except Exception as e:
        raise HTTPException(
            status_code=status.HTTP_500_INTERNAL_SERVER_ERROR,
            detail=f"Error analyzing comments: {str(e)}"
        )

@app.post("/analyze-comments-facebook", response_model=list, tags=["Legacy"])
async def analyze_comments_facebook_legacy(comments: list):
    """Legacy endpoint for backward compatibility"""
    try:
        results = analysis_service.analyze_facebook_comments(comments)
        return results
    except Exception as e:
        raise HTTPException(
            status_code=status.HTTP_500_INTERNAL_SERVER_ERROR,
            detail=f"Error analyzing Facebook comments: {str(e)}"
        )

@app.post("/analyze-comments-raw", response_model=list, tags=["Legacy"])
async def analyze_comments_raw_legacy(request: dict):
    """Legacy endpoint for backward compatibility"""
    try:
        results = analysis_service.analyze_raw_request(request)
        return results
    except Exception as e:
        raise HTTPException(
            status_code=status.HTTP_500_INTERNAL_SERVER_ERROR,
            detail=f"Error analyzing raw comments: {str(e)}"
        )

@app.post("/analyze-comments-dict", response_model=list, tags=["Legacy"])
async def analyze_comments_dict_legacy(request: dict):
    """Legacy endpoint for backward compatibility"""
    try:
        results = analysis_service.analyze_raw_request(request)
        return results
    except Exception as e:
        raise HTTPException(
            status_code=status.HTTP_500_INTERNAL_SERVER_ERROR,
            detail=f"Error analyzing dict comment: {str(e)}"
        )


# Root endpoint
@app.get("/")
async def root():
    """Root endpoint redirecting to health check"""
    from api.endpoints import health_check
    return await health_check()


if __name__ == "__main__":
    import uvicorn
    
    uvicorn.run(
        "main:app",
        host=settings.host,
        port=settings.port,
        reload=settings.debug,
        access_log=settings.is_development
    )
