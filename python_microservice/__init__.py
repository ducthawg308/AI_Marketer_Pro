"""
Comment Analysis Microservice - A rule-based comment classification service.

This microservice provides comment analysis capabilities for Facebook comments
using rule-based classification to determine sentiment, type, and reply priority.
"""

__version__ = "1.0.0"
__author__ = "AI Marketer Pro Team"
__description__ = "Microservice for analyzing Facebook comments using rule-based classification"

# Import main app for easy access
from .main import app

# Import key classes and functions
from .config.settings import settings
from .models.schemas import Comment, AnalysisResult
from .services.classifier import CommentAnalysisService, CommentClassifier

__all__ = [
    "__version__",
    "__author__", 
    "__description__",
    "app",
    "settings",
    "Comment",
    "AnalysisResult", 
    "CommentAnalysisService",
    "CommentClassifier"
]