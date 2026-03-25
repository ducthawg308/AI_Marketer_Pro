# Auto Reply Comment System

Hệ thống tự động reply comment Facebook sử dụng rule-based + LLM (Gemini API) theo yêu cầu.

## Kiến trúc hệ thống

```
Laravel (Main System)
├── Queue Worker (Redis)
├── Python FastAPI Microservice
├── Gemini API
└── Facebook Graph API
```

### Flow hoạt động

1. **Laravel**: Lấy comment từ `campaign_analytics`
2. **Queue Worker**: Gửi comment sang Python FastAPI service
3. **Python Service**: Rule engine + fallback Gemini classification
4. **Laravel**: Lọc comment `should_reply = true`, gọi Gemini để generate reply
5. **Laravel**: Call Facebook API để reply comment

## Cài đặt và cấu hình

### 1. Database

Chạy migrations để tạo bảng:

```bash
php artisan migrate
```

Các bảng được tạo:
- `comment_ai_analysis`: Lưu kết quả phân tích comment
- `comment_auto_replies`: Lưu lịch sử reply

### 2. Python Microservice

Cài đặt dependencies:

```bash
cd python_microservice
pip install -r requirements.txt
```

Chạy dịch vụ:

```bash
python app.py
# Hoặc
uvicorn app:app --host 0.0.0.0 --port 8001
```

### 3. Cấu hình môi trường

Thêm vào `.env`:

```env
ML_MICROSERVICE_URL=http://localhost:8001
GEMINI_API_KEY=your_gemini_api_key
```

### 4. Queue Configuration

Cấu hình Redis queue trong `.env`:

```env
QUEUE_CONNECTION=redis
```

## Sử dụng

### 1. Chạy command xử lý comment

```bash
# Xử lý comment mới
php artisan auto-reply:comments

# Retry các reply thất bại
php artisan auto-reply:retry-failed --limit=10
```

### 2. Cấu hình cron job

Thêm vào crontab:

```bash
# Xử lý comment mỗi 5 phút
*/5 * * * * php /path/to/your/project/artisan auto-reply:comments

# Retry failed replies mỗi giờ
0 * * * * php /path/to/your/project/artisan auto-reply:retry-failed --limit=20
```

### 3. Sử dụng service trong code

```php
use App\Services\Dashboard\CampaignTracking\AutoReplyService;

$service = new AutoReplyService();
$result = $service->processCommentReply($commentData, $campaignAnalyticsId);

// Lấy thống kê
$stats = $service->getReplyStatistics($campaignId);
$performance = $service->getReplyPerformanceByType($campaignId);
```

## Rule-based Classification

### Các loại comment được phát hiện:

1. **Hỏi giá** (`hoi_gia`): "giá bao nhiêu", "bao nhiêu tiền"
2. **Spam** (`spam`): Link, số điện thoại, từ khóa spam
3. **Khiếu nại** (`khieu_nai`): "tệ", "lừa đảo", "thái độ"
4. **Khen ngợi** (`khen_ngoi`): "tốt", "cảm ơn", "uy tín"
5. **Hỏi thông tin** (`hoi_thong_tin`): Comment hỏi thông tin chung

### Priority:
- **High**: Hỏi giá, khiếu nại
- **Medium**: Hỏi thông tin
- **Low**: Khen ngợi

## Gemini API Prompts

### Classification Prompt

```text
Phân loại comment sau theo các tiêu chí:
- sentiment: positive/negative/neutral
- type: hoi_gia/hoi_thong_tin/khieu_nai/spam/khen_ngoi/khac
- should_reply: true/false
- priority: high/medium/low
- confidence: 0.0-1.0

Comment: "{message}"

Trả về JSON: {
  "sentiment": "...",
  "type": "...", 
  "should_reply": true/false,
  "priority": "...",
  "confidence": 0.0-1.0
}
```

### Reply Generation Prompt

```text
Bạn là chuyên viên chăm sóc khách hàng chuyên nghiệp. Hãy viết câu trả lời cho comment sau bằng tiếng Việt, ngắn gọn 1-3 câu, thân thiện và có thể chốt sale nhẹ nếu phù hợp:

Comment: "{message}"
Sentiment: {sentiment}
Type: {type}

Hãy trả lời bằng tiếng Việt, không giải thích, chỉ trả về nội dung câu trả lời dưới dạng JSON: {"reply": "nội dung trả lời"}
```

## Error Handling

### Retry Mechanism

- Max 3 retries cho mỗi reply thất bại
- Random delay 5-30s giữa các lần reply để tránh spam detection
- Log chi tiết lỗi để debug

### Fallback Templates

Khi Gemini API fail, sử dụng template reply theo type:

- `hoi_gia`: "Cảm ơn bạn đã quan tâm! Vui lòng inbox để được tư vấn chi tiết về giá cả nhé!"
- `hoi_thong_tin`: "Cảm ơn bạn đã quan tâm! Vui lòng inbox để được tư vấn chi tiết hơn nhé!"
- `khieu_nai`: "Rất xin lỗi bạn về trải nghiệm chưa tốt. Vui lòng inbox để bên mình hỗ trợ nhanh hơn nhé!"
- `khen_ngoi`: "Cảm ơn bạn đã ủng hộ! Chúc bạn một ngày tốt lành!"

## Performance & Scalability

### Async Processing

- Sử dụng Redis queue để xử lý comment async
- Mỗi comment được xử lý trong job riêng biệt
- Có thể scale queue worker theo nhu cầu

### Rate Limiting

- Random delay 5-30s giữa các reply
- Không reply spam user
- Không reply trùng nội dung

### Monitoring

- Thống kê reply rate, success rate
- Performance theo comment type
- Error tracking và logging

## Security

### Facebook API

- Sử dụng access token từ bảng `user_pages`
- Kiểm tra token validity trước khi reply
- Handle rate limit errors

### Data Validation

- Validate comment data trước khi xử lý
- Sanitize message content
- Check for spam patterns

## Production Deployment

### 1. Supervisor Configuration

Tạo file `/etc/supervisor/conf.d/ai-marketer-worker.conf`:

```ini
[program:ai-marketer-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/your/project/artisan queue:work --sleep=3 --tries=3 --daemon
autostart=true
autorestart=true
user=www-data
numprocs=4
redirect_stderr=true
stdout_logfile=/path/to/your/project/storage/logs/worker.log
```

### 2. Nginx Configuration

```nginx
location /python-microservice {
    proxy_pass http://127.0.0.1:8001;
    proxy_set_header Host $host;
    proxy_set_header X-Real-IP $remote_addr;
}
```

### 3. Environment Variables

```bash
# Production environment
ML_MICROSERVICE_URL=http://your-server:8001
GEMINI_API_KEY=your-production-gemini-key
FACEBOOK_APP_ID=your-facebook-app-id
FACEBOOK_APP_SECRET=your-facebook-app-secret
```

## Testing

### Unit Tests

```bash
# Test Python microservice
cd python_microservice
python -m pytest

# Test Laravel service
php artisan test
```

### Integration Tests

```bash
# Test comment processing flow
php artisan auto-reply:comments --dry-run

# Test reply functionality
php artisan auto-reply:retry-failed --limit=1
```

## Monitoring & Logging

### Log Files

- Laravel logs: `storage/logs/laravel.log`
- Python logs: Console output (configure in app.py)
- Worker logs: Supervisor stdout_logfile

### Metrics

- Total comments processed
- Reply success rate
- Average processing time
- Error rates by type

## Troubleshooting

### Common Issues

1. **Python service not running**: Check if port 8001 is accessible
2. **Facebook API errors**: Check access token validity
3. **Gemini API errors**: Check API key and quota
4. **Queue not processing**: Check Redis connection and worker status

### Debug Commands

```bash
# Check queue status
php artisan queue:work --verbose

# Test Python service
curl http://localhost:8001/

# Test Facebook API
curl -X POST "https://graph.facebook.com/v25.0/{comment_id}/comments" \
  -d "message=Test reply" \
  -d "access_token={page_access_token}"