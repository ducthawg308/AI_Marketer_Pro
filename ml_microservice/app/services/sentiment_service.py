import os
from transformers import pipeline
from ..schemas import SentimentResponse

# Global model variables
sentiment_model = None
intent_model = None

def load_sentiment_models():
    """Load pre-trained BERT models for sentiment analysis"""
    global sentiment_model, intent_model

    try:
        # Load multilingual sentiment model
        sentiment_model = pipeline(
            "sentiment-analysis",
            model="nlptown/bert-base-multilingual-uncased-sentiment",
            return_all_scores=True
        )
        print("✅ Sentiment analysis model loaded from bert-base-multilingual-uncased-sentiment")
    except Exception as e:
        print(f"❌ Failed to load sentiment model: {e}")
        sentiment_model = None

    try:
        # Load zero-shot classification for intent detection
        intent_model = pipeline(
            "zero-shot-classification",
            model="facebook/bart-large-mnli",
            device=0  # Use GPU if available
        )
        print("✅ Intent classification model loaded from bart-large-mnli")
    except Exception as e:
        print(f"❌ Failed to load intent model: {e}")
        intent_model = None

# Load models on module import
load_sentiment_models()

def predict_sentiment(request):
    """Analyze sentiment and intent from comments using real BERT models"""
    comments = request.comments

    if not comments:
        return {
            "overall_sentiment": "neutral",
            "intents": [],
            "risk_level": "low"
        }

    # Initialize results
    overall_sentiment = "neutral"
    intents = []
    total_positive = 0
    total_negative = 0

    # Process each comment
    for comment in comments:
        if not comment or len(comment.strip()) < 3:
            intents.append("neutral")
            continue

        # Sentiment analysis
        try:
            if sentiment_model:
                sentiment_result = sentiment_model(comment)[0]

                # Map BERT sentiment labels to our format
                sentiment_label = sentiment_result[0]['label'] if sentiment_result else "LABEL_1"
                if sentiment_label in ["LABEL_4", "LABEL_5"]:  # Very positive, positive
                    sentiment_code = 1  # positive
                elif sentiment_label in ["LABEL_0", "LABEL_1"]:  # Negative, very negative
                    sentiment_code = -1  # negative
                else:
                    sentiment_code = 0  # neutral

                total_positive += 1 if sentiment_code > 0 else 0
                total_negative += 1 if sentiment_code < 0 else 0
            else:
                sentiment_code = 0  # fallback
        except Exception as e:
            print(f"Sentiment prediction error for '{comment[:50]}...': {e}")
            sentiment_code = 0

        # Intent analysis
        try:
            if intent_model:
                intent_result = intent_model(
                    comment,
                    candidate_labels=["question", "complaint", "praise", "suggestion", "neutral"],
                    multi_label=False
                )
                intents.append(intent_result['labels'][0])
            else:
                # Fallback intent detection based on keywords
                comment_lower = comment.lower()
                if any(q in comment_lower for q in ["?", "có", "làm sao", "như thế nào"]):
                    intent = "question"
                elif any(word in comment_lower for word in ["tệ", "xấu", "chán", "hate", "bad"]):
                    intent = "complaint"
                elif any(word in comment_lower for word in ["tốt", "hay", "love", "good", "tuyệt"]):
                    intent = "praise"
                elif any(word in comment_lower for word in ["có thể", "nên", "should", "suggest"]):
                    intent = "suggestion"
                else:
                    intent = "neutral"
                intents.append(intent)
        except Exception as e:
            print(f"Intent prediction error for '{comment[:50]}...': {e}")
            intents.append("neutral")

    # Determine overall sentiment
    total_comments = len(comments)
    if total_positive > total_negative:
        overall_sentiment = "positive"
    elif total_negative > total_positive:
        overall_sentiment = "negative"
    else:
        overall_sentiment = "neutral"

    # Risk level assessment
    negative_ratio = total_negative / total_comments if total_comments > 0 else 0
    if negative_ratio > 0.3:
        risk_level = "high"
    elif negative_ratio > 0:
        risk_level = "medium"
    else:
        risk_level = "low"

    return {
        "overall_sentiment": overall_sentiment,
        "intents": intents,
        "risk_level": risk_level
    }
