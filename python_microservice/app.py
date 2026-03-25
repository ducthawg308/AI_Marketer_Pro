from fastapi import FastAPI, HTTPException
from pydantic import BaseModel
from typing import List, Dict, Optional
import re
import json
import logging
from datetime import datetime

# Configure logging
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

app = FastAPI(title="Comment Analysis Microservice", version="1.0.0")

class Comment(BaseModel):
    id: str
    message: str
    from_user: Dict
    like_count: int
    created_time: str

    # Handle Facebook API field mapping
    @classmethod
    def from_facebook_data(cls, data: dict):
        """Convert Facebook API comment data to our Comment model"""
        return cls(
            id=data.get('id', ''),
            message=data.get('message', ''),
            from_user=data.get('from', {}),
            like_count=data.get('like_count', 0),
            created_time=data.get('created_time', '')
        )

class AnalysisResult(BaseModel):
    comment_id: str
    message: str
    sentiment: str
    type: str
    should_reply: bool
    priority: str
    confidence: float

# Rule-based classification patterns
class CommentClassifier:
    def __init__(self):
        # Detect hỏi giá
        self.price_patterns = [
            r'giá.*bao nhiêu',
            r'bao nhiêu.*tiền',
            r'giá.*cả',
            r'giá.*tien',
            r'cost.*bao nhiêu',
            r'price.*bao nhiêu',
            r'giá.*đây',
            r'giá.*sản phẩm',
            r'giá.*dịch vụ'
        ]
        
        # Detect spam
        self.spam_patterns = [
            r'http[s]?://(?:[a-zA-Z]|[0-9]|[$-_@.&+]|[!*\\(\\),]|(?:%[0-9a-fA-F][0-9a-fA-F]))+',
            r'\b\d{10,}\b',  # Số điện thoại hoặc số dài
            r'viagra|porn|casino|xxx',
            r'liên hệ.*zalo|inbox.*zalo',
            r'cần.*bán|bán.*hàng',
            r'cần.*mua|mua.*hàng'
        ]
        
        # Detect tiêu cực
        self.negative_patterns = [
            r'tệ|dở|chán|không.*tốt|không.*ổn',
            r'lừa đảo|giả mạo|đồ giả',
            r'thái độ|phục vụ|chăm sóc.*khách hàng',
            r'trả.*phản|phàn nàn|khiếu nại',
            r'không.*hài lòng|hài lòng.*không',
            r'không.*đáng tiền|đáng tiền.*không',
            r'không.*đáng giá|đáng giá.*không'
        ]
        
        # Detect khen ngợi
        self.positive_patterns = [
            r'tốt|ổn|ngon|đẹp|tuyệt|hay|ok|ổn áp',
            r'cảm ơn|thank|thanks',
            r'uy tín|chất lượng|chuyên nghiệp',
            r'đáng tiền|đáng giá|hài lòng',
            r'không.*phàn nàn|không.*khiếu nại'
        ]

    def detect_price_query(self, message: str) -> bool:
        """Detect if comment is asking for price"""
        message_lower = message.lower()
        for pattern in self.price_patterns:
            if re.search(pattern, message_lower):
                return True
        return False

    def detect_spam(self, message: str) -> bool:
        """Detect if comment is spam"""
        if not message or len(message.strip()) < 3:
            return True  # Empty or very short messages are likely spam
            
        message_lower = message.lower()
        for pattern in self.spam_patterns:
            if re.search(pattern, message_lower):
                return True
        return False

    def detect_negative(self, message: str) -> bool:
        """Detect if comment is negative/complaint"""
        message_lower = message.lower()
        for pattern in self.negative_patterns:
            if re.search(pattern, message_lower):
                return True
        return False

    def detect_positive(self, message: str) -> bool:
        """Detect if comment is positive/praise"""
        message_lower = message.lower()
        for pattern in self.positive_patterns:
            if re.search(pattern, message_lower):
                return True
        return False

    def classify_sentiment(self, message: str) -> str:
        """Classify sentiment using rule-based approach"""
        # If message is spam, always return neutral
        if self.detect_spam(message):
            return "neutral"
            
        if self.detect_positive(message):
            return "positive"
        elif self.detect_negative(message):
            return "negative"
        else:
            return "neutral"

    def classify_type(self, message: str, sentiment: str) -> str:
        """Classify comment type using rule-based approach"""
        if self.detect_spam(message):
            return "spam"
        elif self.detect_price_query(message):
            return "hoi_gia"
        elif sentiment == "negative":
            return "khieu_nai"
        elif sentiment == "positive":
            return "khen_ngoi"
        else:
            return "hoi_thong_tin"

    def should_reply(self, comment_type: str, sentiment: str) -> bool:
        """Determine if comment should be replied"""
        if comment_type == "spam":
            return False
        elif comment_type in ["hoi_gia", "hoi_thong_tin", "khieu_nai"]:
            return True
        elif comment_type == "khen_ngoi":
            return True
        else:
            return False

    def get_priority(self, comment_type: str, sentiment: str) -> str:
        """Get reply priority"""
        if comment_type in ["hoi_gia", "khieu_nai"]:
            return "high"
        elif comment_type == "hoi_thong_tin":
            return "medium"
        elif comment_type == "khen_ngoi":
            return "low"
        else:
            return "medium"

    def get_confidence(self, comment_type: str, sentiment: str) -> float:
        """Get classification confidence"""
        if comment_type == "spam":
            return 0.95
        elif comment_type in ["hoi_gia", "khieu_nai"]:
            return 0.90
        elif comment_type in ["hoi_thong_tin", "khen_ngoi"]:
            return 0.85
        else:
            return 0.70

    def analyze_comment(self, comment: Comment) -> AnalysisResult:
        """Analyze a single comment"""
        message = comment.message or ""
        
        # Rule-based classification
        sentiment = self.classify_sentiment(message)
        comment_type = self.classify_type(message, sentiment)
        should_reply = self.should_reply(comment_type, sentiment)
        priority = self.get_priority(comment_type, sentiment)
        confidence = self.get_confidence(comment_type, sentiment)

        return AnalysisResult(
            comment_id=comment.id,
            message=message,
            sentiment=sentiment,
            type=comment_type,
            should_reply=should_reply,
            priority=priority,
            confidence=confidence
        )

classifier = CommentClassifier()

@app.post("/analyze-comments", response_model=List[AnalysisResult])
async def analyze_comments(comments: List[Comment]):
    """Analyze multiple comments using rule-based classification"""
    try:
        results = []
        
        for comment in comments:
            result = classifier.analyze_comment(comment)
            results.append(result)
            
        logger.info(f"Analyzed {len(results)} comments")
        return results
        
    except Exception as e:
        logger.error(f"Error analyzing comments: {str(e)}")
        raise HTTPException(status_code=500, detail=str(e))


@app.post("/analyze-comments-facebook", response_model=List[AnalysisResult])
async def analyze_comments_facebook(comments: List[dict]):
    """Analyze Facebook API comment data using rule-based classification"""
    try:
        results = []
        
        for comment_data in comments:
            # Convert Facebook API data to our Comment model
            comment = Comment.from_facebook_data(comment_data)
            result = classifier.analyze_comment(comment)
            results.append(result)
            
        logger.info(f"Analyzed {len(results)} Facebook comments")
        return results
        
    except Exception as e:
        logger.error(f"Error analyzing Facebook comments: {str(e)}")
        raise HTTPException(status_code=500, detail=str(e))


@app.post("/analyze-comments-raw", response_model=List[AnalysisResult])
async def analyze_comments_raw(request: dict):
    """Analyze Facebook API comment data using rule-based classification (raw dict)"""
    try:
        results = []
        
        # Handle both list and dict input
        if 'comments' in request:
            comments = request['comments']
        else:
            comments = [request] if isinstance(request, dict) else request
            
        for comment_data in comments:
            # Convert Facebook API data to our Comment model
            comment = Comment.from_facebook_data(comment_data)
            result = classifier.analyze_comment(comment)
            results.append(result)
            
        logger.info(f"Analyzed {len(results)} Facebook comments")
        return results
        
    except Exception as e:
        logger.error(f"Error analyzing Facebook comments: {str(e)}")
        raise HTTPException(status_code=500, detail=str(e))


@app.post("/analyze-comments-dict", response_model=List[AnalysisResult])
async def analyze_comments_dict(request: dict):
    """Analyze Facebook API comment data using rule-based classification (dict input)"""
    try:
        results = []
        
        # Handle dict input directly
        comment = Comment.from_facebook_data(request)
        result = classifier.analyze_comment(comment)
        results.append(result)
            
        logger.info(f"Analyzed 1 Facebook comment")
        return results
        
    except Exception as e:
        logger.error(f"Error analyzing Facebook comment: {str(e)}")
        raise HTTPException(status_code=500, detail=str(e))

@app.get("/")
async def root():
    """Health check endpoint"""
    return {
        "message": "Comment Analysis Microservice is running",
        "timestamp": datetime.now().isoformat(),
        "version": "1.0.0"
    }

if __name__ == "__main__":
    import uvicorn
    uvicorn.run(app, host="0.0.0.0", port=8001)