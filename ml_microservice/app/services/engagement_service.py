import joblib
import os
from datetime import datetime

# Global model variable
model = None

def load_model():
    """Load the engagement prediction model on startup"""
    global model
    model_path = os.path.join(os.path.dirname(__file__), '..', 'models', 'engagement.joblib')
    if os.path.exists(model_path):
        try:
            model = joblib.load(model_path)
            print("Engagement model loaded successfully")
        except Exception as e:
            print(f"Error loading engagement model: {e}")
            model = None

# Load model on module import
load_model()

def predict_engagement(request):
    """Predict engagement based on post data"""
    if model is None:
        # Stub response if model not available
        return {
            "predicted_engagement": 100.0,
            "growth_rate": 5.0,
            "best_time": "Evening (18:00-20:00)",
            "suggestions": "Add more visual content and emojis to increase engagement"
        }

    # Real prediction logic - EXTRACT 10 FEATURES TO MATCH TRAINING DATA
    content_length = len(request.content)
    hour_of_day = datetime.fromisoformat(request.time_posted).hour
    weekday = datetime.fromisoformat(request.time_posted).weekday()  # 0=Monday
    is_weekend = 1 if weekday in [5, 6] else 0  # Saturday=5, Sunday=6

    # Status type features (from training data logic)
    status_type = "unknown"  # We don't have this field in API, assume normal text
    is_photo = 1 if "photo" in status_type.lower() else 0
    is_video = 1 if "video" in status_type.lower() else 0
    is_link = 1 if "link" in status_type.lower() else 0

    # Full feature vector matching training data - CREATE DataFrame with column names
    import pandas as pd

    features_df = pd.DataFrame([{
        'content_length': content_length,
        'reacts': request.reacts,
        'shares': request.shares,
        'comments': request.comments,
        'hour': hour_of_day,
        'weekday': weekday,
        'is_weekend': is_weekend,
        'is_photo': is_photo,
        'is_video': is_video,
        'is_link': is_link
    }])

    try:
        predicted_engagement = float(model.predict(features_df)[0])
        print(f"✅ Model prediction: {predicted_engagement} from features: {features_df.iloc[0].to_dict()}")
    except Exception as e:
        print(f"❌ Prediction error: {e}")
        print("🔧 Feature names expected by model:", getattr(model, 'feature_names_', 'Unknown'))
        predicted_engagement = 50.0  # fallback

    # Calculate growth rate (dummy logic)
    growth_rate = ((request.reacts + request.shares + request.comments) / max(content_length, 1)) * 10

    # Suggest best posting time (dummy logic)
    if hour_of_day < 12:
        best_time = "Evening (18:00-20:00)"
    elif hour_of_day < 18:
        best_time = "Late afternoon"
    else:
        best_time = "Morning (8:00-10:00)"

    # Suggestions based on prediction
    if predicted_engagement < 50:
        suggestions = "Improve content: add images, ask questions, use trending hashtags"
    else:
        suggestions = "Good engagement potential - maintain this style"

    return {
        "predicted_engagement": predicted_engagement,
        "growth_rate": growth_rate,
        "best_time": best_time,
        "suggestions": suggestions
    }
