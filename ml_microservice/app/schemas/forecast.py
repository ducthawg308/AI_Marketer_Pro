from pydantic import BaseModel
from typing import List, Optional, Any

class ForecastDataPoint(BaseModel):
    ds: str  # Date string
    y: float  # Value

class ForecastRequest(BaseModel):
    data: List[ForecastDataPoint]  # Historical data points
    periods: int = 3  # Number of periods to forecast

class ForecastResponse(BaseModel):
    dates: List[str]  # Forecast dates
    predicted_values: List[float]  # Forecast values
    lower_bounds: List[float]  # Lower confidence bounds
    upper_bounds: List[float]  # Upper confidence bounds
    growth_trend: float  # Growth trend percentage
    seasonal_index: float  # Seasonal adjustment factor
    method: str  # Forecasting method used
