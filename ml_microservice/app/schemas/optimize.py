from pydantic import BaseModel
from typing import Dict

class OptimizeRequest(BaseModel):
    content: str  # Nội dung bài viết cần tối ưu hóa

class OptimizeResponse(BaseModel):
    optimized_content: str  # Nội dung đã tối ưu hóa
    improvements: Dict[str, str]  # Từ điển gợi ý cải thiện, e.g., {"tone": "more positive", "cta": "add buy button", "keywords": "add trending keywords"}
