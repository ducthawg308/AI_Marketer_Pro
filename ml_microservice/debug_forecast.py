#!/usr/bin/env python3
"""
Debug script to test forecast prediction model
"""

from app.services.forecast_service import perform_forecast
from app.schemas.forecast import ForecastRequest, ForecastDataPoint

def test_forecast():
    print("🔍 Testing forecast prediction...")

    # Test case 1: Sample market data
    forecast_data = [
        {"ds": "2024-01-01", "y": 80},
        {"ds": "2024-02-01", "y": 85},
        {"ds": "2024-03-01", "y": 90},
        {"ds": "2024-04-01", "y": 95},
        {"ds": "2024-05-01", "y": 100}
    ]

    try:
        result = perform_forecast(forecast_data, periods=3)
        print("✅ Test 1 result:", result)
    except Exception as e:
        print("❌ Test 1 error:", e)
        import traceback
        traceback.print_exc()

    # Test case 2: Simple increasing trend
    forecast_data2 = [
        {"ds": "2024-01-01", "y": 10},
        {"ds": "2024-02-01", "y": 20},
        {"ds": "2024-03-01", "y": 30}
    ]

    try:
        result2 = perform_forecast(forecast_data2, periods=2)
        print("✅ Test 2 result:", result2)
    except Exception as e:
        print("❌ Test 2 error:", e)

    # Test case 3: Empty data
    try:
        result3 = perform_forecast([], periods=3)
        print("✅ Test 3 (empty data) result:", result3)
    except Exception as e:
        print("❌ Test 3 error:", e)

if __name__ == "__main__":
    test_forecast()
