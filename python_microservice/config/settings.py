"""
Configuration settings for the Comment Analysis Microservice.
"""
import os
from typing import Dict, Any
from dataclasses import dataclass
from enum import Enum


class Environment(Enum):
    """Environment types"""
    DEVELOPMENT = "development"
    TESTING = "testing"
    PRODUCTION = "production"


@dataclass
class Settings:
    """Application settings"""
    # Server settings
    host: str = os.getenv("HOST", "0.0.0.0")
    port: int = int(os.getenv("PORT", "8001"))
    debug: bool = os.getenv("DEBUG", "False").lower() == "true"
    
    # Application settings
    app_name: str = "Comment Analysis Microservice"
    version: str = "1.0.0"
    
    # Logging settings
    log_level: str = os.getenv("LOG_LEVEL", "INFO")
    log_format: str = "%(asctime)s - %(name)s - %(levelname)s - %(message)s"
    
    # Classification settings
    min_message_length: int = int(os.getenv("MIN_MESSAGE_LENGTH", "3"))
    classification_confidence_threshold: float = float(os.getenv("CONFIDENCE_THRESHOLD", "0.7"))
    
    # Environment
    environment: Environment = Environment(os.getenv("ENVIRONMENT", "development"))
    
    # API Keys
    gemini_api_key: str = os.getenv("GEMINI_API_KEY", "")
    serpapi_api_key: str = os.getenv("SERPAPI_API_KEY", "")
    
    @property
    def is_development(self) -> bool:
        """Check if running in development environment"""
        return self.environment == Environment.DEVELOPMENT
    
    @property
    def is_production(self) -> bool:
        """Check if running in production environment"""
        return self.environment == Environment.PRODUCTION


# Global settings instance
settings = Settings()