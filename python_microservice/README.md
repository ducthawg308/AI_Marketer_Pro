# Comment Analysis Microservice

Microservice Python sử dụng FastAPI để phân tích comment Facebook theo phương pháp rule-based. Được refactor lại theo kiến trúc microservices chuẩn để dễ dàng phát triển và mở rộng.

## 🏗️ Architecture

### Directory Structure
```
python_microservice/
├── main.py                 # Application entry point
├── config/                 # Configuration management
│   ├── __init__.py
│   └── settings.py
├── models/                 # Data models and schemas
│   ├── __init__.py
│   └── schemas.py
├── services/               # Business logic layer
│   ├── __init__.py
│   └── classifier.py
├── api/                    # API endpoints
│   ├── __init__.py
│   └── endpoints.py
├── utils/                  # Utility functions
│   ├── __init__.py
│   └── logging.py
├── Dockerfile             # Docker configuration
├── docker-compose.yml     # Docker Compose setup
├── requirements.txt       # Python dependencies
└── README.md              # This file
```

### Architecture Layers
1. **Presentation Layer**: `api/` - FastAPI endpoints and routing
2. **Service Layer**: `services/` - Business logic and comment analysis
3. **Model Layer**: `models/` - Data validation and serialization
4. **Configuration Layer**: `config/` - Application settings and environment
5. **Utility Layer**: `utils/` - Shared utilities and logging

## 🚀 Quick Start

### Prerequisites
- Python 3.11+
- Docker (optional)

### Installation

```bash
cd python_microservice
pip install -r requirements.txt
```

### Running the Service

#### Development Mode
```bash
python main.py
```

#### Using uvicorn
```bash
uvicorn main:app --host 0.0.0.0 --port 8001 --reload
```

#### Docker
```bash
# Build and run
docker-compose up --build

# Run in background
docker-compose up -d

# View logs
docker-compose logs -f comment-analysis
```

## 🔧 Configuration

### Environment Variables
```bash
# Server settings
HOST=0.0.0.0
PORT=8001
DEBUG=true

# Application settings
ENVIRONMENT=development
LOG_LEVEL=INFO
LOG_FORMAT="%(asctime)s - %(name)s - %(levelname)s - %(message)s"

# Classification settings
MIN_MESSAGE_LENGTH=3
CONFIDENCE_THRESHOLD=0.7
```

### Configuration File
Edit `config/settings.py` to modify default settings:
```python
@dataclass
class Settings:
    host: str = os.getenv("HOST", "0.0.0.0")
    port: int = int(os.getenv("PORT", "8001"))
    debug: bool = os.getenv("DEBUG", "False").lower() == "true"
    # ... more settings
```

## 📡 API Endpoints

### Health Check
```http
GET /
```

### Analyze Comments
```http
POST /api/v1/analyze-comments
Content-Type: application/json

{
  "comments": [
    {
      "id": "123456789_987654321",
      "message": "Sản phẩm này giá bao nhiêu vậy?",
      "from_user": {
        "id": "123456789",
        "name": "Người dùng"
      },
      "like_count": 0,
      "created_time": "2026-03-25T12:00:00+0000"
    }
  ]
}
```

### Analyze Facebook Comments
```http
POST /api/v1/analyze-comments-facebook
Content-Type: application/json

[
  {
    "id": "123456789_987654321",
    "message": "Sản phẩm này giá bao nhiêu vậy?",
    "from": {
      "id": "123456789",
      "name": "Người dùng"
    },
    "like_count": 0,
    "created_time": "2026-03-25T12:00:00+0000"
  }
]
```

### Batch Analysis
```http
POST /api/v1/analyze-batch
Content-Type: application/json

{
  "comments": [
    {
      "id": "123456789_987654321",
      "message": "Sản phẩm này giá bao nhiêu vậy?",
      "from_user": {
        "id": "123456789",
        "name": "Người dùng"
      },
      "like_count": 0,
      "created_time": "2026-03-25T12:00:00+0000"
    }
  ]
}
```

### Get Service Metrics
```http
GET /api/v1/metrics
```

### Get Classification Patterns
```http
GET /api/v1/patterns
```

## 🎯 Rule-based Classification

### Comment Types Detected

1. **Hỏi giá** (`hoi_gia`): Các comment hỏi về giá cả
   - Pattern: "giá bao nhiêu", "bao nhiêu tiền", "giá cả", v.v.

2. **Spam** (`spam`): Comment spam, quảng cáo
   - Pattern: Link, số điện thoại, từ khóa spam

3. **Khiếu nại** (`khieu_nai`): Comment tiêu cực, phàn nàn
   - Pattern: "tệ", "lừa đảo", "thái độ", v.v.

4. **Khen ngợi** (`khen_ngoi`): Comment tích cực
   - Pattern: "tốt", "cảm ơn", "uy tín", v.v.

5. **Hỏi thông tin** (`hoi_thong_tin`): Comment hỏi thông tin chung

### Priority Levels
- **High**: Hỏi giá, khiếu nại
- **Medium**: Hỏi thông tin
- **Low**: Khen ngợi

### Confidence Scores
- Spam: 0.95
- Hỏi giá, khiếu nại: 0.90
- Hỏi thông tin, khen ngợi: 0.85
- Khác: 0.70

## 🔧 Development

### Adding New Comment Types
1. Add regex patterns to `services/classifier.py`
2. Update classification logic
3. Add corresponding priority and confidence rules

### Extending API Endpoints
1. Create new endpoint in `api/endpoints.py`
2. Add route to the router
3. Implement business logic in `services/`

### Custom Configuration
1. Add new settings to `config/settings.py`
2. Use environment variables for deployment
3. Update validation as needed

## 🐳 Docker Deployment

### Build Image
```bash
docker build -t comment-analysis:latest .
```

### Run Container
```bash
docker run -p 8001:8001 \
  -e ENVIRONMENT=production \
  -e LOG_LEVEL=INFO \
  comment-analysis:latest
```

### Docker Compose
```bash
# Start with Redis cache
docker-compose up -d

# Start without cache
docker-compose up -d --profile production
```

## 📊 Monitoring

### Health Check
```bash
curl http://localhost:8001/
```

### Service Metrics
```bash
curl http://localhost:8001/api/v1/metrics
```

### Classification Patterns
```bash
curl http://localhost:8001/api/v1/patterns
```

## 🔗 Integration with Laravel

Dịch vụ này được gọi từ Laravel Job `ProcessCommentForAutoReply` để phân tích comment trước khi sử dụng Gemini để tạo reply.

### Example Laravel Integration
```php
$response = Http::post('http://comment-analysis:8001/api/v1/analyze-comments', [
    'comments' => $comments
]);

$analysisResults = $response->json();
```

## 🧪 Testing

### Run Tests
```bash
# Install test dependencies
pip install pytest pytest-asyncio httpx

# Run tests
pytest tests/
```

### Manual Testing
```bash
# Test with curl
curl -X POST http://localhost:8001/api/v1/analyze-comments \
  -H "Content-Type: application/json" \
  -d '{
    "comments": [
      {
        "id": "test_1",
        "message": "Sản phẩm này giá bao nhiêu vậy?",
        "from_user": {"id": "user1", "name": "Test User"},
        "like_count": 0,
        "created_time": "2026-03-25T12:00:00+0000"
      }
    ]
  }'
```

## 📈 Performance

### Optimization Features
- Async request handling
- Efficient regex patterns
- Minimal memory footprint
- Health checks and monitoring

### Scaling
- Stateless design for horizontal scaling
- Docker containerization
- Load balancing support

## 🛠️ Troubleshooting

### Common Issues

1. **Port already in use**
   ```bash
   # Check port usage
   lsof -i :8001
   
   # Kill process
   kill -9 <PID>
   ```

2. **Docker build fails**
   ```bash
   # Clean build
   docker system prune -a
   docker build --no-cache -t comment-analysis .
   ```

3. **Environment variables not loaded**
   ```bash
   # Check environment
   docker-compose logs comment-analysis
   ```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests
5. Submit a pull request

## 📄 License

MIT License - see LICENSE file for details.
