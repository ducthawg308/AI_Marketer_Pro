"""
Comment classification service using rule-based approach.
"""
import re
import logging
from typing import List, Dict, Optional
from datetime import datetime

from models.schemas import Comment, AnalysisResult
from config.settings import settings

logger = logging.getLogger(__name__)


class CommentClassifier:
    """Rule-based comment classifier for sentiment and type analysis"""
    
    def __init__(self):
        """Initialize classifier with regex patterns for different comment types"""
        # Detect hỏi giá (price inquiries)
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
        
        # Detect tiêu cực (negative comments)
        self.negative_patterns = [
            r'tệ|dở|chán|không.*tốt|không.*ổn',
            r'lừa đảo|giả mạo|đồ giả',
            r'thái độ|phục vụ|chăm sóc.*khách hàng',
            r'trả.*phản|phàn nàn|khiếu nại',
            r'không.*hài lòng|hài lòng.*không',
            r'không.*đáng tiền|đáng tiền.*không',
            r'không.*đáng giá|đáng giá.*không'
        ]
        
        # Detect khen ngợi (positive comments)
        self.positive_patterns = [
            r'tốt|ổn|ngon|đẹp|tuyệt|hay|ok|ổn áp',
            r'cảm ơn|thank|thanks',
            r'uy tín|chất lượng|chuyên nghiệp',
            r'đáng tiền|đáng giá|hài lòng',
            r'không.*phàn nàn|không.*khiếu nại'
        ]
        
        logger.info("CommentClassifier initialized with rule-based patterns")

    def detect_price_query(self, message: str) -> bool:
        """Detect if comment is asking for price"""
        if not message:
            return False
            
        message_lower = message.lower()
        for pattern in self.price_patterns:
            if re.search(pattern, message_lower):
                return True
        return False

    def detect_spam(self, message: str) -> bool:
        """Detect if comment is spam"""
        if not message or len(message.strip()) < settings.min_message_length:
            return True  # Empty or very short messages are likely spam
            
        message_lower = message.lower()
        for pattern in self.spam_patterns:
            if re.search(pattern, message_lower):
                return True
        return False

    def detect_negative(self, message: str) -> bool:
        """Detect if comment is negative/complaint"""
        if not message:
            return False
            
        message_lower = message.lower()
        for pattern in self.negative_patterns:
            if re.search(pattern, message_lower):
                return True
        return False

    def detect_positive(self, message: str) -> bool:
        """Detect if comment is positive/praise"""
        if not message:
            return False
            
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
        """Analyze a single comment and return classification result"""
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

    def analyze_comments(self, comments: List[Comment]) -> List[AnalysisResult]:
        """Analyze multiple comments and return classification results"""
        results = []
        
        for comment in comments:
            try:
                result = self.analyze_comment(comment)
                results.append(result)
            except Exception as e:
                logger.error(f"Error analyzing comment {comment.id}: {str(e)}")
                # Return a neutral result for failed analysis
                results.append(AnalysisResult(
                    comment_id=comment.id,
                    message=comment.message,
                    sentiment="neutral",
                    type="error",
                    should_reply=False,
                    priority="medium",
                    confidence=0.0
                ))
        
        logger.info(f"Successfully analyzed {len(results)} comments")
        return results


class CommentAnalysisService:
    """Service layer for comment analysis operations"""
    
    def __init__(self):
        self.classifier = CommentClassifier()
        logger.info("CommentAnalysisService initialized")

    def analyze_single_comment(self, comment: Comment) -> AnalysisResult:
        """Analyze a single comment"""
        return self.classifier.analyze_comment(comment)

    def analyze_batch_comments(self, comments: List[Comment]) -> List[AnalysisResult]:
        """Analyze a batch of comments"""
        return self.classifier.analyze_comments(comments)

    def analyze_facebook_comments(self, facebook_data: List[Dict]) -> List[AnalysisResult]:
        """Analyze Facebook API comment data"""
        comments = []
        for data in facebook_data:
            try:
                comment = Comment.from_facebook_data(data)
                comments.append(comment)
            except Exception as e:
                logger.error(f"Error converting Facebook data to Comment: {str(e)}")
                continue
        
        return self.analyze_batch_comments(comments)

    def analyze_raw_request(self, request_data: Dict) -> List[AnalysisResult]:
        """Analyze raw request data (supports both single dict and list of dicts)"""
        if 'comments' in request_data:
            # Handle batch request
            facebook_data = request_data['comments']
        else:
            # Handle single comment request
            facebook_data = [request_data] if isinstance(request_data, dict) else request_data
        
        return self.analyze_facebook_comments(facebook_data)