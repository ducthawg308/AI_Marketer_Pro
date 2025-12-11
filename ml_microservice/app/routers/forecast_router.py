from fastapi import APIRouter
from ..schemas import ForecastRequest, ForecastResponse
from ..services.forecast_service import perform_forecast

router = APIRouter()

@router.post("/predict-forecast", response_model=ForecastResponse)
def predict_forecast(request: ForecastRequest):
    """Perform AI market forecasting on time-series data"""
    # Convert Pydantic models to dict list for service
    forecast_data = [point.model_dump() for point in request.data]

    result = perform_forecast(forecast_data, request.periods)
    return result
