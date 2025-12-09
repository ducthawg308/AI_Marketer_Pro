# AI Marketer Pro ML Microservice

Microservice machine learning cho dự đoán engagement, phân tích sentiment, tối ưu content và phát hiện bất thường trong AI Marketer Pro.

## 📋 Mục lục

- [Tổng quan](#tổng-quan)
- [Flow hoạt động](#flow-hoạt-động)
- [Kiến trúc](#kiến-trúc)
- [Training Pipeline](#training-pipeline)
- [API Endpoints](#api-endpoints)
- [Tích hợp Laravel](#tích-hợp-laravel)
- [Lệnh chạy](#lệnh-chạy)

## 📖 Tổng quan

Microservice bao gồm 4 mô hình chính:

1. **🎯 Engagement Prediction** - XGBoost: Dự đoán mức độ tương tác bài post
2. **😊 Sentiment Analysis** - BERT: Phân tích cảm xúc & ý định bình luận
3. **✨ Content Optimization** - Sentence BERT: Tối ưu nội dung để tăng engagement
4. **📊 Anomaly Detection** - Statistical ML: Phát hiện bất thường trong engagement

## 🔄 Flow hoạt động

### Training Phase
```
Data Collection → Preprocessing → Model Training → Model Saving → Deployment
```

**Detail từng phase:**

1. **Data Collection:**
   - Engagement data: reactions, comments, shares, post content, timestamps
   - Sentiment data: comment texts với labels positive/neutral/negative
   - Content templates: high-performing posts để tối ưu
   - Time-series data: engagement history cho anomaly detection

2. **Preprocessing:**
   - Text cleaning & tokenization
   - Feature engineering (content_length, hour, weekday)
   - Label encoding cho predictors
   - Embedding generation cho semantic analysis

3. **Model Training:**
   - XGBoost cho regression problems (~1000 samples, CV 5-fold)
   - BERT fine-tuning trên labeled sentiment data
   - Isolation Forest hoặc threshold-based cho anomaly detection
   - Sentence-BERT training cho content similarity

4. **Model Saving:**
   - XGBoost: joblib.dump(model, 'engagement.joblib')
   - BERT: model.save_pretrained('sentiment_model/')
   - Anomaly: không cần save (statistical methods)

### Prediction Phase
```
Laravel Request → ML API Call → Model Load → Feature Processing → Prediction → Response → UI Display
```

**Chi tiết từng bước:**

1. **Laravel call ML APIs:**
   ```php
   $response = Http::post('http://localhost:8001/predict-engagement', [
       'content' => $post->message,
       'reacts' => $post->reactions,
       // ...
   ]);
   ```

2. **FastAPI xử lý:**
   ```python
   @app.post("/predict-engagement")
   def predict(request: EngagementRequest):
       # Load model on startup
       features = [len(request.content), request.reacts, ...]
       prediction = model.predict([features])[0]
       return EngagementResponse(...)
   ```

3. **UI hiển thị kết quả:**
   ```
   Laravel Controller → pass $ml_insights to Blade view
   → Display predictions trong cards với colors/icons
   ```

## 🏗️ Kiến trúc

### FastAPI Structure
```
ml_microservice/
├── app/
│   ├── main.py              # FastAPI instance & router include
│   ├── routers/             # API endpoints (4 files)
│   ├── schemas/             # Pydantic request/response
│   ├── services/            # ML logic & model loading
│   ├── models/              # Saved models (.joblib, .pt)
│   └── config.py            # MySQL connection config
├── train_models.py          # Training pipeline
└── requirements.txt         # Dependencies
```

### Laravel Integration
```
Laravel Controller
    ↓
MLService::predictEngagement($data)
    ↓
HTTP POST to FastAPI:8001
    ↓
FastAPI process & return predictions
    ↓
Blade view render results
    ↓
User see AI-powered insights
```

## 🎯 API Endpoints

| Endpoint | Method | Description | Input | Output |
|----------|--------|-------------|-------|--------|
| `/predict-engagement` | POST | Dự đoán engagement | `content`, `reacts`, `shares`, `comments`, `time_posted` | `predicted_engagement`, `growth_rate`, `best_time`, `suggestions` |
| `/predict-sentiment` | POST | Phân tích sentiment | `comments[]` | `overall_sentiment`, `intents[]`, `risk_level` |
| `/optimize-content` | POST | Tối ưu content | `content` | `optimized_content`, `improvements{}` |
| `/detect-anomaly` | POST | Phát hiện anomaly | `engagement_data[]`, `timestamps[]` | `is_anomaly`, `anomaly_score`, `message` |

## 🚀 Training Pipeline

### 1. Prepare Data

**Real Data from Campaign Analytics Table:**
```python
# Query real data from campaign_analytics table
query = """
    SELECT
        ca.reactions_total,
        ca.comments,
        ca.shares,
        ca.post_message,
        ca.post_created_time,
        ca.status_type
    FROM campaign_analytics ca
    WHERE (ca.reactions_total + ca.comments + ca.shares) >= 10
    AND ca.post_created_time IS NOT NULL
"""

# Features extracted:
features = [
    'reacts', 'comments', 'shares',        # Basic engagement
    'content_length',                      # Text analysis
    'hour', 'weekday', 'is_weekend',       # Time-based features
    'is_photo', 'is_video', 'is_link'      # Content type features
]

# Target: Weighted engagement score
target = (
    reacts * 1.5 +      # Reactions weight
    comments * 3 +      # Comments high engagement value
    shares * 5          # Shares viral indicator
)
```

**Fallback: Synthetic Data (if insufficient real data):**
```python
# Only used if database has < 100 training samples
np.random.seed(42)
n_samples = 1000

features = {
    'content_length': np.random.randint(50, 500, n_samples),
    'reacts': np.random.randint(0, 1000, n_samples),
    'shares': np.random.randint(0, 100, n_samples),
    'comments': np.random.randint(0, 50, n_samples),
    'hour': np.random.randint(0, 24, n_samples),
    # ... more realistic features
}
```

**Sentiment Model Data:**
```python
# Real Facebook comments with sentiment labels
training_data = [
    {"text": "Great product! Love it", "label": "positive"},
    {"text": "This sucks, terrible quality", "label": "negative"},
    # ... thousands of examples
]
```

**Optimization Model Data:**
```python
# High-performing post templates
successful_posts = [
    "Amazing deal! Buy now and save 50% #Deal",
    "What a fantastic experience! Loved every moment #Happy",
    # ...
]

# Embedding similar posts together
embeddings = SentenceTransformer('bert-base-nli-mean-tokens')
sentence_embeddings = embeddings.encode(successful_posts)
```

### 2. Verify Database Connection (Important!)

Before training, ensure database connection works:

```bash
cd ml_microservice
python test_db_connection.py
```

**Expected output:**
```
🔍 Testing ML Microservice Database Connection
✅ Connected to database: ai_marketer_pro
✅ Table 'campaign_analytics' exists with 20 columns:
  - id: int(11)
  - campaign_id: int(11) unsigned
  - ad_schedule_id: int(11) unsigned
  - facebook_post_id: varchar(255)
  - reactions_total: int(11)
  - comments: int(11)
  - shares: int(11)
  - post_message: text
  - post_created_time: timestamp
  - status_type: varchar(255)
  (and more...)
✅ Total records in campaign_analytics: 1250

📊 Sample Data Statistics:
   - Total qualifying records: 850
   - Average reactions: 125.6
   - Average comments: 23.4
   - Average shares: 8.9

✅ All database checks passed!
You can now run: python train_models.py
```

### 3. Train Models with Real Data

```bash
python train_models.py

**What happens in training:**

1. **XGBoost Training:**
   ```python
   from xgboost import XGBRegressor

   model = XGBRegressor(
       objective='reg:squarederror',
       n_estimators=100,
       learning_rate=0.1,
       max_depth=6,
       random_state=42
   )
   model.fit(X_train, y_train)
   joblib.dump(model, 'app/models/engagement.joblib')
   ```

2. **BERT Training:**
   ```python
   from transformers import BertForSequenceClassification, TrainingArguments

   model = BertForSequenceClassification.from_pretrained(
       'nlptown/bert-base-multilingual-uncased-sentiment',
       num_labels=3  # positive, neutral, negative
   )

   training_args = TrainingArguments(
       output_dir='./results',
       num_train_epochs=3,
       per_device_train_batch_size=16,
   )

   trainer = Trainer(
       model=model,
       args=training_args,
       train_dataset=train_dataset,
   )
   trainer.train()
   model.save_pretrained('./app/models/sentiment')
   ```

3. **Sentence BERT (optional for advanced optimization):**
   ```python
   model = SentenceTransformer('all-MiniLM-L6-v2')
   model.fit(samples, warmup_steps=100, epochs=1)
   model.save('./app/models/optimizer')
   ```

### 3. Model Loading & Prediction

**At Startup:**
```python
# engagement_service.py
model = None
def load_model():
    global model
    try:
        model = joblib.load('app/models/engagement.joblib')
    except:
        pass  # stub mode
```

**Prediction:**
```python
def predict_engagement(request):
    if model is None:
        return STUB_RESPONSE

    # Feature engineering
    content_length = len(request.content)
    reacts = request.reacts
    shares = request.shares
    comments = request.comments
    time = datetime.fromisoformat(request.time_posted)
    hour = time.hour
    weekday = time.weekday()

    features = [content_length, reacts, shares, comments, hour, weekday]

    prediction = model.predict([features])[0]
    return EngagementResponse(...)
```

## 🔗 Tích hợp Laravel

### MLService trong Laravel
```php
// app/Services/Dashboard/CampaignTracking/MLService.php
public function predictEngagement(array $data) {
    return Http::post('http://localhost:8001/predict-engagement', $data)->json();
}

public function analyzePost($analytics) {
    $results = [
        'engagement_prediction' => $this->predictEngagement([...]),
        'sentiment_analysis' => $this->predictSentiment([...]),
        'content_optimization' => $this->optimizeContent([...]),
    ];
    return $results;
}
```

### Trong Controller
```php
// CampaignTrackingController@show
$mlService = app(MLService::class);
$mlAvailable = $mlService->isServiceAvailable();

foreach($schedules as $schedule) {
    if($schedule->latest_analytics && $mlAvailable) {
        $schedule->ml_insights = $mlService->analyzePost($schedule->latest_analytics);
    }
}

// Pass to view
return view('show', compact('campaign', 'schedules', 'totalStats', 'mlInsights'));
```

### Hiển thị trong Blade
```blade
@if(isset($schedule->ml_insights['engagement_prediction']))
    <div class="bg-green-50 p-4 rounded-lg">
        <h5>AI Engagement Prediction:</h5>
        <p>Predicted: {{ number_format($schedule->ml_insights['engagement_prediction']['predicted_engagement']) }}</p>
        @isset($schedule->ml_insights['sentiment_analysis'])
            <p>Sentiment: {{ $schedule->ml_insights['sentiment_analysis']['overall_sentiment'] }}</p>
        @endisset
    </div>
@endif
```

## 🏁 Lệnh chạy

### Setup & Training
```bash
# 1. Navigate to microservice directory
cd c:\laragon\www\ai_marketer_pro\ml_microservice

# 2. Install Python dependencies
pip install -r requirements.txt

# 3. (Optional) Train models
python train_models.py

# 4. Start FastAPI server
uvicorn app.main:app --reload --host 0.0.0.0 --port 8001

# API docs available at: http://localhost:8001/docs
```

### Test Individual APIs
```bash
# Engagement prediction
curl -X POST "http://localhost:8001/predict-engagement" \
-H "Content-Type: application/json" \
-d '{
  "content": "Amazing product! Buy now #Deal",
  "reacts": 10, "shares": 5, "comments": 3,
  "time_posted": "2023-10-01T14:30:00"
}'

# Sentiment analysis
curl -X POST "http://localhost:8001/predict-sentiment" \
-H "Content-Type: application/json" \
-d '{"comments": ["Great!", "Love it", "Not bad"]}'

# Content optimization
curl -X POST "http://localhost:8001/optimize-content" \
-H "Content-Type: application/json" \
-d '{"content": "Simple promotion text"}'

# Anomaly detection
curl -X POST "http://localhost:8001/detect-anomaly" \
-H "Content-Type: application/json" \
-d '{"engagement_data": [100,120,110,1500,140],"timestamps": ["2023-10-01","2023-10-02","2023-10-03","2023-10-04","2023-10-05"]}'
```

### Laravel Integration Testing
1. Start ML service trên port 8001
2. Truy cập campaign tracking page trong Laravel
3. ML insights sẽ được hiển thị tự động nếu có data

## 🚨 Troubleshooting

### ML Service Down
- Service không active → display warning message in UI
- API timeout → fallback to stub responses
- Log errors trong Laravel logs

### Model Not Trained
- Sử dụng dummy responses
- User can retrain với `python train_models.py`

### Performance Issues
- Add caching layer (Redis)
- Batch predictions
- Async processing cho heavy requests

## 🔮 Production Deployment

### Docker Image
```dockerfile
FROM python:3.11-slim
WORKDIR /app
COPY requirements.txt .
RUN pip install --no-cache-dir -r requirements.txt
COPY . .
EXPOSE 8000
CMD ["uvicorn", "app.main:app", "--host", "0.0.0.0", "--port", "8000"]
```

### Scaling Options
- Kubernetes deployment với HPA (horizontal pod autoscaling)
- Load balancer phân phối requests
- Async ML tasks với worker queues

### Monitoring
- Prometheus metrics
- Health check endpoints
- Model performance tracking
- Prediction accuracy monitoring

---

**Ready to boost your marketing campaigns with AI insights! 🎉**
