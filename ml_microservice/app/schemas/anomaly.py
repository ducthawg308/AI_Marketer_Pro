from pydantic import BaseModel
from typing import List

class AnomalyRequest(BaseModel):
    engagement_data: List[float]  # Danh sách dữ liệu engagement theo thời gian
    timestamps: List[str]         # Danh sách timestamp tương ứng

class AnomalyResponse(BaseModel):
    is_anomaly: bool              # Có bất thường hay không
    anomaly_score: float          # Điểm số bất thường (0-1)
    message: str                  # Thông báo, e.g., "Normal" hoặc "Spike detected at time X"
