"""
Service layer for the Comment Analysis Microservice.
"""
from .classifier import CommentAnalysisService, CommentClassifier

__all__ = ["CommentAnalysisService", "CommentClassifier"]