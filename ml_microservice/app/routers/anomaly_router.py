from fastapi import APIRouter
from ..schemas import AnomalyRequest, AnomalyResponse
from ..services.anomaly_service import detect_anomaly

router = APIRouter()

@router.post("/detect-anomaly", response_model=AnomalyResponse)
def detect(request: AnomalyRequest):
    return detect_anomaly(request)
