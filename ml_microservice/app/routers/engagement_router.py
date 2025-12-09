from fastapi import APIRouter
from ..schemas import EngagementRequest, EngagementResponse
from ..services.engagement_service import predict_engagement

router = APIRouter()

@router.post("/predict-engagement", response_model=EngagementResponse)
def predict(request: EngagementRequest):
    return predict_engagement(request)
