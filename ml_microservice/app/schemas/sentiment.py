from pydantic import BaseModel

class SentimentRequest(BaseModel):
    comments: list[str]  # Danh sách bình luận cần phân tích

class SentimentResponse(BaseModel):
    overall_sentiment: str   # positive, neutral, negative
    intents: list[str]       # Danh sách ý định cho từng bình luận (e.g., ["question", "complaint", "praise"])
    risk_level: str          # low, medium, high (rủi ro dựa trên sentiment)
