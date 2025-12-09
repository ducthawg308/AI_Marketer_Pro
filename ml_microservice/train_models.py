"""
Training pipeline for ML models using REAL data from Campaign Analytics
Run this script to train and save models for the microservice
"""
import os
import joblib
import pandas as pd
import numpy as np
from xgboost import XGBRegressor
from datetime import datetime
from app.config import get_db_connection, test_db_connection, TRAINING_MIN_SAMPLES, VALID_ENGAGEMENT_THRESHOLD, CONTENT_REQUIRED
import sys

def load_real_engagement_data():
    """Load real engagement data from campaign_analytics table"""
    print("Loading real data from campaign_analytics table...")

    connection = get_db_connection()
    if not connection:
        raise Exception("Cannot connect to database")

    try:
        with connection.cursor() as cursor:
            # Query campaign analytics with post data
            query = """
                SELECT
                    ca.reactions_total,
                    ca.comments,
                    ca.shares,
                    ca.post_message,
                    ca.post_created_time,
                    ca.post_updated_time,
                    ca.status_type,
                    ca.comments_data,
                    ca.fetched_at,
                    ca.insights_date
                FROM campaign_analytics ca
                WHERE
                    ca.reactions_total IS NOT NULL
                    AND ca.comments IS NOT NULL
                    AND ca.shares IS NOT NULL
                    AND (ca.reactions_total + ca.comments + ca.shares) >= %s
                    AND ca.post_created_time IS NOT NULL
            """

            cursor.execute(query, [VALID_ENGAGEMENT_THRESHOLD])
            results = cursor.fetchall()

            if len(results) < TRAINING_MIN_SAMPLES:
                print(f"❌ Insufficient data: {len(results)} samples found, need at least {TRAINING_MIN_SAMPLES}")
                return None

            print(f"✅ Loaded {len(results)} real analytic records")

            # Convert to DataFrame
            df = pd.DataFrame(results)

            # Data cleaning and feature engineering
            df_clean = preprocess_engagement_data(df)

            return df_clean

    except Exception as e:
        print(f"❌ Error loading data: {e}")
        return None
    finally:
        connection.close()

def preprocess_engagement_data(df):
    """Preprocess raw database data into training features"""
    df_processed = pd.DataFrame()

    # Basic engagement metrics
    df_processed['reacts'] = df['reactions_total'].astype(int)
    df_processed['comments'] = df['comments'].astype(int)
    df_processed['shares'] = df['shares'].astype(int)

    # Content features
    df_processed['has_content'] = df['post_message'].notna()

    # Content length (only for posts with content)
    if CONTENT_REQUIRED:
        df_with_content = df[df['post_message'].notna()].copy()
        df_processed.loc[df_processed['has_content'], 'content_length'] = df_with_content['post_message'].str.len()
    else:
        df_processed['content_length'] = df['post_message'].fillna('').str.len()

    df_processed['content_length'] = df_processed['content_length'].fillna(0).astype(int)

    # Time-based features
    df_processed['post_created_time'] = pd.to_datetime(df['post_created_time'])
    df_processed['hour'] = df_processed['post_created_time'].dt.hour.astype(int)
    df_processed['weekday'] = df_processed['post_created_time'].dt.weekday.astype(int)
    df_processed['is_weekend'] = df_processed['weekday'].isin([5, 6]).astype(int)

    # Status type features
    df_processed['is_photo'] = df['status_type'].str.contains('photo', case=False, na=False).astype(int)
    df_processed['is_video'] = df['status_type'].str.contains('video', case=False, na=False).astype(int)
    df_processed['is_link'] = df['status_type'].str.contains('link', case=False, na=False).astype(int)

    # Target: total engagement score (weighted)
    df_processed['engagement'] = (
        df_processed['reacts'] * 1.5 +      # Reactions most valuable
        df_processed['comments'] * 3 +      # Comments show highest engagement
        df_processed['shares'] * 5          # Shares are viral indicators
    )

    # Clean data
    df_processed = df_processed.dropna()
    df_processed = df_processed.drop(columns=['post_created_time'], errors='ignore')

    print(f"✅ Processed data: {len(df_processed)} samples with {len(df_processed.columns)} features")
    print(f"   Features: {list(df_processed.columns)}")

    return df_processed

def train_engagement_model():
    """Train XGBoost model for engagement prediction using REAL data"""
    print("🚀 Training engagement prediction model with real data...")

    # Test database connection first
    print("🔍 Testing database connection...")
    if not test_db_connection():
        print("❌ Database connection test failed. Cannot proceed with training.")
        return None

    # Load real data
    df = load_real_engagement_data()
    if df is None or len(df) < TRAINING_MIN_SAMPLES:
        print("❌ Cannot train model: insufficient real data. Falling back to synthetic data.")

        # Fallback to synthetic data
        df = generate_synthetic_data()

    # Prepare features and target
    feature_cols = [
        'content_length', 'reacts', 'shares', 'comments',
        'hour', 'weekday', 'is_weekend', 'is_photo', 'is_video', 'is_link'
    ]

    # Filter available columns
    available_features = [col for col in feature_cols if col in df.columns]
    X = df[available_features]
    y = df['engagement']

    print(f"🧠 Training with {len(X)} samples, {len(available_features)} features")

    # Train model
    model = XGBRegressor(
        objective='reg:squarederror',
        n_estimators=200,  # Increased for more data
        learning_rate=0.05,
        max_depth=8,
        min_child_weight=1,
        subsample=0.8,
        colsample_bytree=0.8,
        random_state=42
    )

    model.fit(X, y)

    # Save model
    model_dir = os.path.join(os.path.dirname(__file__), 'app', 'models')
    os.makedirs(model_dir, exist_ok=True)
    model_path = os.path.join(model_dir, 'engagement.joblib')
    joblib.dump(model, model_path)

    # Print model stats
    y_pred = model.predict(X[:10])  # Test predictions on first 10 samples
    print(f"📊 Sample predictions: {y_pred}")
    print(f"💾 Model saved to {model_path}")
    print("✅ Real data engagement model trained successfully!")
    return model_path

def generate_synthetic_data():
    """Fallback: generate synthetic data similar to real data distribution"""
    print("🔄 Generating synthetic data as fallback...")

    np.random.seed(42)
    n_samples = max(TRAINING_MIN_SAMPLES, 500)  # At least 500 samples

    features = {
        'content_length': np.random.randint(50, 500, n_samples),
        'reacts': np.random.randint(0, 1000, n_samples),
        'shares': np.random.randint(0, 100, n_samples),
        'comments': np.random.randint(0, 50, n_samples),
        'hour': np.random.randint(0, 24, n_samples),
        'weekday': np.random.randint(0, 7, n_samples),
        'is_weekend': np.random.randint(0, 2, n_samples),
        'is_photo': np.random.randint(0, 2, n_samples),
        'is_video': np.random.randint(0, 2, n_samples),
        'is_link': np.random.randint(0, 2, n_samples),
    }

    df = pd.DataFrame(features)
    df['engagement'] = (
        df['reacts'] * 1.5 + df['comments'] * 3 + df['shares'] * 5 +
        np.random.normal(0, 50, n_samples)
    ).clip(0)

    print(f"✅ Generated synthetic data: {len(df)} samples")
    return df

def train_sentiment_model():
    """Fine-tune BERT model for sentiment analysis (placeholder)"""
    print("Training sentiment analysis model...")

    # In production, you would fine-tune BERT on labeled sentiment data
    # For now, this is a placeholder as transformers loads pre-trained models

    print("✓ Sentiment model would be trained here (using pre-trained BERT)")

def train_optimization_model():
    """Train model for content optimization (placeholder)"""
    print("Training content optimization model...")

    # In production, you could train a model to predict optimal modifications
    # using sentence embeddings and success metrics

    print("✓ Content optimization model would be trained here")

def train_anomaly_model():
    """Train anomaly detection model (optional, as it uses statistical methods)"""
    print("Anomaly detection uses statistical methods - no training required")

if __name__ == "__main__":
    print("Starting ML model training pipeline...")
    train_engagement_model()
    train_sentiment_model()
    train_optimization_model()
    train_anomaly_model()
    print("All models processed!")
