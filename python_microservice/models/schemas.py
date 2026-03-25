"""
Pydantic models and schemas for the Comment Analysis Microservice.
"""
from typing import Dict, Optional, List
from datetime import datetime
from pydantic import BaseModel, Field, validator


class Comment(BaseModel):
    """Comment model representing a Facebook comment"""
    id: str = Field(..., description="Unique identifier for the comment")
    message: str = Field(..., description="The comment text content")
    from_user: Dict = Field(..., description="User information who posted the comment")
    like_count: int = Field(0, description="Number of likes on the comment")
    created_time: str = Field(..., description="Timestamp when the comment was created")

    @validator('message')
    def validate_message(cls, v):
        """Validate that message is not empty"""
        if not v or not v.strip():
            raise ValueError('Message cannot be empty')
        return v.strip()

    @classmethod
    def from_facebook_data(cls, data: dict) -> 'Comment':
        """Convert Facebook API comment data to our Comment model"""
        return cls(
            id=data.get('id', ''),
            message=data.get('message', ''),
            from_user=data.get('from', {}),
            like_count=data.get('like_count', 0),
            created_time=data.get('created_time', '')
        )

    class Config:
        schema_extra = {
            "example": {
                "id": "123456789_987654321",
                "message": "Sản phẩm này giá bao nhiêu vậy?",
                "from_user": {
                    "id": "123456789",
                    "name": "Người dùng"
                },
                "like_count": 0,
                "created_time": "2026-03-25T12:00:00+0000"
            }
        }


class AnalysisResult(BaseModel):
    """Analysis result model for comment classification"""
    comment_id: str = Field(..., description="ID of the analyzed comment")
    message: str = Field(..., description="Original comment message")
    sentiment: str = Field(..., description="Sentiment classification: positive, negative, or neutral")
    type: str = Field(..., description="Comment type classification")
    should_reply: bool = Field(..., description="Whether the comment should be replied to")
    priority: str = Field(..., description="Reply priority: high, medium, or low")
    confidence: float = Field(..., ge=0.0, le=1.0, description="Classification confidence score")

    @validator('sentiment')
    def validate_sentiment(cls, v):
        """Validate sentiment value"""
        valid_sentiments = ['positive', 'negative', 'neutral']
        if v not in valid_sentiments:
            raise ValueError(f'Sentiment must be one of: {", ".join(valid_sentiments)}')
        return v

    @validator('priority')
    def validate_priority(cls, v):
        """Validate priority value"""
        valid_priorities = ['high', 'medium', 'low']
        if v not in valid_priorities:
            raise ValueError(f'Priority must be one of: {", ".join(valid_priorities)}')
        return v

    class Config:
        schema_extra = {
            "example": {
                "comment_id": "123456789_987654321",
                "message": "Sản phẩm này giá bao nhiêu vậy?",
                "sentiment": "neutral",
                "type": "hoi_gia",
                "should_reply": True,
                "priority": "high",
                "confidence": 0.9
            }
        }


class HealthCheck(BaseModel):
    """Health check response model"""
    message: str = Field(..., description="Service status message")
    timestamp: str = Field(..., description="Current timestamp in ISO format")
    version: str = Field(..., description="Service version")
    environment: str = Field(..., description="Current environment")


class BatchAnalysisRequest(BaseModel):
    """Request model for batch comment analysis"""
    comments: List[Comment] = Field(..., description="List of comments to analyze")

    @validator('comments')
    def validate_comments(cls, v):
        """Validate that comments list is not empty"""
        if not v:
            raise ValueError('Comments list cannot be empty')
        return v


class BatchAnalysisResponse(BaseModel):
    """Response model for batch comment analysis"""
    results: List[AnalysisResult] = Field(..., description="List of analysis results")
    total_comments: int = Field(..., description="Total number of comments analyzed")
    processed_at: str = Field(..., description="Timestamp when processing was completed")