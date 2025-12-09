from fastapi import APIRouter
from ..schemas import SentimentRequest, SentimentResponse
from ..services.sentiment_service import predict_sentiment

router = APIRouter()

@router.post("/predict-sentiment", response_model=SentimentResponse)
def predict(request: SentimentRequest):
    return predict_sentiment(request)
