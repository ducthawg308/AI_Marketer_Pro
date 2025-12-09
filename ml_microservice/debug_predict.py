#!/usr/bin/env python3
"""
Debug script to test engagement prediction model
"""

from app.services.engagement_service import predict_engagement
from app.schemas.engagement import EngagementRequest

def test_predict():
    print("🔍 Testing engagement prediction...")

    # Test case 1: Input hiện tại đang dùng
    request = EngagementRequest(
        content="Amazing product with great features!",
        reacts=50,
        shares=20,
        comments=15,
        time_posted="2023-10-01T14:30:00"
    )

    try:
        result = predict_engagement(request)
        print("✅ Test 1 result:", result)
    except Exception as e:
        print("❌ Test 1 error:", e)

    # Test case 2: Simple input
    request2 = EngagementRequest(
        content="Test post",
        reacts=10,
        shares=5,
        comments=3,
        time_posted="2023-10-01T12:00:00"
    )

    try:
        result2 = predict_engagement(request2)
        print("✅ Test 2 result:", result2)
    except Exception as e:
        print("❌ Test 2 error:", e)

    # Test raw model prediction
    from app.services.engagement_service import model
    print("Model loaded:", model is not None)

    if model:
        # Test with raw features
        test_features = [10, 10, 5, 3, 12, 1]  # content_length, reacts, shares, comments, hour, weekday
        try:
            raw_pred = model.predict([test_features])
            print("Raw model prediction:", raw_pred)
        except Exception as e:
            print("Raw prediction error:", e)

def test_feature_extraction():
    print("\n🔍 Testing feature extraction...")

    from app.services.engagement_service import predict_engagement
    from app.schemas.engagement import EngagementRequest
    from datetime import datetime

    request = EngagementRequest(
        content="Amazing product with great features!",
        reacts=50,
        shares=20,
        comments=15,
        time_posted="2023-10-01T14:30:00"
    )

    try:
        # Extract features manually
        content_length = len(request.content)
        hour_of_day = datetime.fromisoformat(request.time_posted).hour
        weekday = datetime.fromisoformat(request.time_posted).weekday()

        features = [content_length, request.reacts, request.shares, request.comments, hour_of_day, weekday]
        print("Extracted features:", features)

    except Exception as e:
        print("❌ Feature extraction error:", e)
        import traceback
        traceback.print_exc()

if __name__ == "__main__":
    test_predict()
    test_feature_extraction()
