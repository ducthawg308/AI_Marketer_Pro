"""
Logging utilities for the Comment Analysis Microservice.
"""
import logging
import sys
from typing import Optional


def setup_logging(level: str = "INFO", format_string: Optional[str] = None):
    """
    Setup logging configuration for the application.
    
    Args:
        level: Logging level (DEBUG, INFO, WARNING, ERROR, CRITICAL)
        format_string: Custom format string for log messages
    """
    if format_string is None:
        format_string = "%(asctime)s - %(name)s - %(levelname)s - %(message)s"
    
    # Configure root logger
    logging.basicConfig(
        level=getattr(logging, level.upper()),
        format=format_string,
        handlers=[
            logging.StreamHandler(sys.stdout)
        ]
    )
    
    # Configure uvicorn access logs
    uvicorn_access_logger = logging.getLogger("uvicorn.access")
    uvicorn_access_logger.handlers = []
    uvicorn_access_logger.propagate = True
    
    # Configure uvicorn error logs
    uvicorn_error_logger = logging.getLogger("uvicorn.error")
    uvicorn_error_logger.handlers = []
    uvicorn_error_logger.propagate = True
    
    # Configure fastapi logs
    fastapi_logger = logging.getLogger("fastapi")
    fastapi_logger.handlers = []
    fastapi_logger.propagate = True


def get_logger(name: str) -> logging.Logger:
    """
    Get a logger with the specified name.
    
    Args:
        name: Logger name
        
    Returns:
        Configured logger instance
    """
    return logging.getLogger(name)


class RequestLogger:
    """Utility class for logging HTTP requests"""
    
    @staticmethod
    def log_request(method: str, url: str, headers: dict = None, body: dict = None):
        """Log incoming HTTP request"""
        logger = get_logger("request")
        logger.info(f"Request: {method} {url}")
        
        if headers:
            logger.debug(f"Headers: {headers}")
        
        if body:
            logger.debug(f"Body: {body}")
    
    @staticmethod
    def log_response(status_code: int, response_time: float, body: dict = None):
        """Log outgoing HTTP response"""
        logger = get_logger("response")
        logger.info(f"Response: {status_code} ({response_time:.2f}ms)")
        
        if body:
            logger.debug(f"Body: {body}")