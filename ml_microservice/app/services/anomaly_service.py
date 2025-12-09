import numpy as np
from ..schemas import AnomalyResponse

def detect_anomaly(request):
    """Detect anomalies in engagement data using statistical methods"""
    data = request.engagement_data

    if len(data) < 5:
        return {
            "is_anomaly": False,
            "anomaly_score": 0.0,
            "message": "Not enough data points for anomaly detection (minimum 5 required)"
        }

    # Calculate statistical thresholds
    mean = np.mean(data)
    std = np.std(data) if np.std(data) != 0 else 1
    max_val = max(data)
    min_val = min(data)

    # Simple anomaly detection: check if values deviate significantly
    threshold = mean + 2 * std
    anomaly_indices = [i for i, val in enumerate(data) if abs(val - mean) > 2 * std]

    if anomaly_indices:
        anomaly_score = max((val - mean) / std for val in data if abs(val - mean) > 2 * std)
        is_anomaly = True
        timestamp = request.timestamps[anomaly_indices[0]] if anomaly_indices else "unknown"
        message = f"Anomaly detected! Significant { 'spike' if max_val > threshold else 'drop' } in engagement at {timestamp}"
    else:
        anomaly_score = 0.0
        is_anomaly = False
        message = "Engagement data is within normal range"

    # For more advanced ML-based detection:
    # from sklearn.ensemble import IsolationForest
    # model = IsolationForest(contamination=0.1, random_state=42)
    # X = np.array(data).reshape(-1, 1)
    # model.fit(X)
    # is_anomaly = model.predict(X).astype(int).min() == -1
    # anomaly_score = model.decision_function(X).max()

    return {
        "is_anomaly": is_anomaly,
        "anomaly_score": float(anomaly_score),
        "message": message
    }
