from pydantic import BaseModel

class EngagementRequest(BaseModel):
    content: str  # Nội dung bài post
    reacts: int    # Số lượng react hiện tại
    shares: int    # Số lượng share hiện tại
    comments: int  # Số lượng comment hiện tại
    time_posted: str  # Thời gian đăng, định dạng ISO "YYYY-MM-DDTHH:MM:SS"

class EngagementResponse(BaseModel):
    predicted_engagement: float  # Dự đoán tổng số tương tác
    growth_rate: float            # Tỷ lệ tăng trưởng (%)
    best_time: str                # Gợi ý thời điểm đăng tốt nhất
    suggestions: str              # Gợi ý cải thiện nội dung
