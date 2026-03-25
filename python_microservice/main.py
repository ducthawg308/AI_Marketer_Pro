"""
Main application entry point for the Comment Analysis Microservice.
"""
import logging
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
from utils.logging import setup_logging

# Setup logging
setup_logging(settings.log_level, settings.log_format)


@asynccontextmanager
async def lifespan(app: FastAPI) -> AsyncGenerator[None, None]:
    """Application lifespan events"""
    # Startup
    logger = logging.getLogger(__name__)
    logger.info(f"Starting {settings.app_name} v{settings.version}")
    logger.info(f"Environment: {settings.environment.value}")
    logger.info(f"Debug mode: {settings.debug}")
    
    yield
    
    # Shutdown
    logger.info(f"Shutting down {settings.app_name}")


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
        logger = logging.getLogger(__name__)
        
        # Log request
        logger.info(f"{request.method} {request.url}")
        
        # Process request
        response = await call_next(request)
        
        # Log response
        logger.info(f"Response status: {response.status_code}")
        
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
import logging

logger = logging.getLogger(__name__)
analysis_service = CommentAnalysisService()

@app.post("/analyze-comments", response_model=list, tags=["Legacy"])
async def analyze_comments_legacy(comments: list):
    """Legacy endpoint for backward compatibility"""
    try:
        results = analysis_service.analyze_batch_comments(comments)
        logger.info(f"Successfully analyzed {len(results)} comments (legacy endpoint)")
        return results
    except Exception as e:
        logger.error(f"Error analyzing comments (legacy): {str(e)}")
        raise HTTPException(
            status_code=status.HTTP_500_INTERNAL_SERVER_ERROR,
            detail=f"Error analyzing comments: {str(e)}"
        )

@app.post("/analyze-comments-facebook", response_model=list, tags=["Legacy"])
async def analyze_comments_facebook_legacy(comments: list):
    """Legacy endpoint for backward compatibility"""
    try:
        results = analysis_service.analyze_facebook_comments(comments)
        logger.info(f"Successfully analyzed {len(results)} Facebook comments (legacy endpoint)")
        return results
    except Exception as e:
        logger.error(f"Error analyzing Facebook comments (legacy): {str(e)}")
        raise HTTPException(
            status_code=status.HTTP_500_INTERNAL_SERVER_ERROR,
            detail=f"Error analyzing Facebook comments: {str(e)}"
        )

@app.post("/analyze-comments-raw", response_model=list, tags=["Legacy"])
async def analyze_comments_raw_legacy(request: dict):
    """Legacy endpoint for backward compatibility"""
    try:
        results = analysis_service.analyze_raw_request(request)
        logger.info(f"Successfully analyzed {len(results)} comments from raw request (legacy endpoint)")
        return results
    except Exception as e:
        logger.error(f"Error analyzing raw comments (legacy): {str(e)}")
        raise HTTPException(
            status_code=status.HTTP_500_INTERNAL_SERVER_ERROR,
            detail=f"Error analyzing raw comments: {str(e)}"
        )

@app.post("/analyze-comments-dict", response_model=list, tags=["Legacy"])
async def analyze_comments_dict_legacy(request: dict):
    """Legacy endpoint for backward compatibility"""
    try:
        results = analysis_service.analyze_raw_request(request)
        logger.info(f"Successfully analyzed 1 comment from dict request (legacy endpoint)")
        return results
    except Exception as e:
        logger.error(f"Error analyzing dict comment (legacy): {str(e)}")
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
    
    # Configure uvicorn logging
    uvicorn_log_config = {
        "version": 1,
        "disable_existing_loggers": False,
        "formatters": {
            "default": {
                "()": "uvicorn.logging.DefaultFormatter",
                "fmt": settings.log_format,
                "use_colors": None,
            },
        },
        "handlers": {
            "default": {
                "formatter": "default",
                "class": "logging.StreamHandler",
                "stream": "ext://sys.stderr",
            },
        },
        "loggers": {
            "uvicorn": {"handlers": ["default"], "level": "INFO"},
            "uvicorn.error": {"level": "INFO"},
            "uvicorn.access": {"handlers": ["default"], "level": "INFO", "propagate": False},
        },
    }
    
    uvicorn.run(
        "main:app",
        host=settings.host,
        port=settings.port,
        reload=settings.debug,
        log_config=uvicorn_log_config,
        access_log=settings.is_development
    )