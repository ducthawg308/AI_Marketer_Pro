# Auto Reply Comment System - Testing Guide

Hướng dẫn chi tiết cách test và debug hệ thống auto-reply comment.

## 1. Chuẩn bị môi trường test

### 1.1 Cài đặt Python Microservice
```bash
cd python_microservice
pip install -r requirements.txt
```

### 1.2 Chạy Python Microservice
```bash
# Terminal 1: Chạy Python service
python app.py
# Hoặc
uvicorn app:app --host 0.0.0.0 --port 8001
```

### 1.3 Cấu hình môi trường
Thêm vào `.env`:
```env
ML_MICROSERVICE_URL=http://localhost:8001
GEMINI_API_KEY=your_gemini_api_key
QUEUE_CONNECTION=redis
```

### 1.4 Chạy Redis Queue Worker
```bash
# Terminal 2: Chạy queue worker
php artisan queue:work --tries=3 --timeout=60
```

## 2. Test từng bước hệ thống

### 2.1 Test Python Microservice
```bash
# Test Python service hoạt động
curl http://localhost:8001/

# Test phân tích comment
curl -X POST http://localhost:8001/analyze-comments \
  -H "Content-Type: application/json" \
  -d '{
    "comments": [
      {
        "id": "test_123",
        "message": "Giá bao nhiêu vậy?",
        "from_user": {"name": "Test User"},
        "like_count": 0,
        "created_time": "2025-01-01T00:00:00Z"
      }
    ]
  }'
```

**Expected output:**
```json
[
  {
    "comment_id": "test_123",
    "message": "Giá bao nhiêu vậy?",
    "sentiment": "neutral",
    "type": "hoi_gia",
    "should_reply": true,
    "priority": "high",
    "confidence": 0.9
  }
]
```

### 2.2 Test Gemini API
```bash
# Test Gemini API trực tiếp
php artisan tinker

>>> use App\Traits\GeminiApiTrait;
>>> $trait = new class { use GeminiApiTrait; };
>>> $result = $trait->callGeminiApi("Bạn là chuyên viên chăm sóc khách hàng. Trả lời: 'Giá bao nhiêu vậy?' bằng tiếng Việt, ngắn gọn 1-2 câu.");
>>> print_r($result);
```

### 2.3 Test Database Models
```bash
php artisan tinker

>>> // Test CommentAiAnalysis model
>>> $analysis = new App\Models\Dashboard\CampaignTracking\CommentAiAnalysis();
>>> $analysis->comment_id = 'test_123';
>>> $analysis->message = 'Test message';
>>> $analysis->sentiment = 'positive';
>>> $analysis->type = 'test';
>>> $analysis->should_reply = true;
>>> $analysis->priority = 'medium';
>>> $analysis->confidence = 0.8;
>>> $analysis->save();

>>> // Test CommentAutoReply model
>>> $reply = new App\Models\Dashboard\CampaignTracking\CommentAutoReply();
>>> $reply->comment_id = 'test_123';
>>> $reply->reply_text = 'Test reply';
>>> $reply->status = 'success';
>>> $reply->save();
```

## 3. Test toàn bộ flow

### 3.1 Tạo dữ liệu test trong database
```bash
php artisan tinker

>>> // Tạo CampaignAnalytics với comments_data
>>> $campaignAnalytics = App\Models\Dashboard\CampaignTracking\CampaignAnalytics::create([
...     'campaign_id' => 1,
...     'ad_schedule_id' => 1,
...     'comments_data' => [
...         [
...             'id' => 'test_comment_001',
...             'message' => 'Giá bao nhiêu vậy?',
...             'from_user' => ['name' => 'Test User'],
...             'like_count' => 0,
...             'created_time' => '2025-01-01T00:00:00Z'
...         ],
...         [
...             'id' => 'test_comment_002',
...             'message' => 'Sản phẩm này có tốt không?',
...             'from_user' => ['name' => 'Test User 2'],
...             'like_count' => 1,
...             'created_time' => '2025-01-01T01:00:00Z'
...         ]
...     ]
... ]);
```

### 3.2 Chạy command xử lý comment
```bash
# Terminal 3: Chạy command xử lý comment
php artisan auto-reply:comments
```

**Expected output:**
```
=== STARTING AUTO-REPLY COMMENT PROCESSING ===
Step 1: Fetching unanalyzed comments...
Found 1 comments with unanalyzed data
Processing comment batch from campaign analytics ID: 1
Found 2 individual comments in this batch
  - Dispatching job for comment ID: test_comment_001
  - Dispatching job for comment ID: test_comment_002
=== PROCESSING SUMMARY ===
Total campaign analytics processed: 1
Total jobs dispatched: 2
Auto-reply comment processing completed successfully.
```

### 3.3 Kiểm tra log xử lý job
```bash
# Xem log từ queue worker (Terminal 2)
# Các log sẽ hiển thị chi tiết từng bước xử lý
```

**Expected log output:**
```
[2025-01-01 10:00:00] local.INFO: ProcessCommentForAutoReply: Starting job for comment ID: test_comment_001
[2025-01-01 10:00:00] local.INFO: ProcessCommentForAutoReply: === PROCESSING COMMENT: test_comment_001 ===
[2025-01-01 10:00:00] local.INFO: ProcessCommentForAutoReply: Comment message: Giá bao nhiêu vậy?
[2025-01-01 10:00:00] local.INFO: ProcessCommentForAutoReply: Step 1: Checking if comment already analyzed...
[2025-01-01 10:00:00] local.INFO: ProcessCommentForAutoReply: Comment not analyzed yet, proceeding...
[2025-01-01 10:00:00] local.INFO: ProcessCommentForAutoReply: Step 2: Calling Python microservice for analysis...
[2025-01-01 10:00:00] local.INFO: ProcessCommentForAutoReply: Calling Python service for comment test_comment_001
[2025-01-01 10:00:00] local.INFO: ProcessCommentForAutoReply: Python analysis successful
[2025-01-01 10:00:00] local.INFO: ProcessCommentForAutoReply: Analysis result: {"sentiment":"neutral","type":"hoi_gia","should_reply":true,"priority":"high","confidence":0.9}
[2025-01-01 10:00:00] local.INFO: ProcessCommentForAutoReply: Step 3: Saving analysis result to database...
[2025-01-01 10:00:00] local.INFO: ProcessCommentForAutoReply: Saving analysis for comment test_comment_001
[2025-01-01 10:00:00] local.INFO: ProcessCommentForAutoReply: Analysis saved successfully with ID: 1
[2025-01-01 10:00:00] local.INFO: ProcessCommentForAutoReply: Step 4: Checking if comment should be replied to...
[2025-01-01 10:00:00] local.INFO: ProcessCommentForAutoReply: Comment should be replied to (priority: high)
[2025-01-01 10:00:00] local.INFO: ProcessCommentForAutoReply: === PROCESSING AUTO-REPLY FOR COMMENT: test_comment_001 ===
[2025-01-01 10:00:00] local.INFO: ProcessCommentForAutoReply: Step 1: Generating reply with Gemini API...
[2025-01-01 10:00:00] local.INFO: ProcessCommentForAutoReply: Generating reply with Gemini API for comment: test_comment_001
[2025-01-01 10:00:00] local.INFO: GeminiApiTrait: Starting Gemini API call
[2025-01-01 10:00:00] local.INFO: GeminiApiTrait: Prompt: [prompt content]
[2025-01-01 10:00:00] local.INFO: GeminiApiTrait: API Key found, making request...
[2025-01-01 10:00:00] local.INFO: GeminiApiTrait: Request URL: [URL]
[2025-01-01 10:00:00] local.INFO: GeminiApiTrait: Request data: [data]
[2025-01-01 10:00:00] local.INFO: GeminiApiTrait: Executing cURL request...
[2025-01-01 10:00:00] local.INFO: GeminiApiTrait: cURL request completed
[2025-01-01 10:00:00] local.INFO: GeminiApiTrait: HTTP Code: 200
[2025-01-01 10:00:00] local.INFO: GeminiApiTrait: Response: [response]
[2025-01-01 10:00:00] local.INFO: GeminiApiTrait: cURL Error: 
[2025-01-01 10:00:00] local.INFO: GeminiApiTrait: API call successful, parsing response...
[2025-01-01 10:00:00] local.INFO: GeminiApiTrait: Raw response text: {"reply": "Cảm ơn bạn đã quan tâm! Vui lòng inbox để được tư vấn chi tiết về giá cả nhé!"}
[2025-01-01 10:00:00] local.INFO: GeminiApiTrait: Parsed response data: {"reply":"Cảm ơn bạn đã quan tâm! Vui lòng inbox để được tư vấn chi tiết về giá cả nhé!"}
[2025-01-01 10:00:00] local.INFO: GeminiApiTrait: Gemini API call completed successfully
[2025-01-01 10:00:00] local.INFO: ProcessCommentForAutoReply: Gemini reply generated successfully
[2025-01-01 10:00:00] local.INFO: ProcessCommentForAutoReply: Generated reply: Cảm ơn bạn đã quan tâm! Vui lòng inbox để được tư vấn chi tiết về giá cả nhé!
[2025-01-01 10:00:00] local.INFO: ProcessCommentForAutoReply: Step 2: Getting campaign analytics and page info...
[2025-01-01 10:00:00] local.INFO: ProcessCommentForAutoReply: Page info retrieved successfully (Page ID: [page_id])
[2025-01-01 10:00:00] local.INFO: ProcessCommentForAutoReply: Step 3: Sending reply to Facebook...
[2025-01-01 10:00:00] local.INFO: ProcessCommentForAutoReply: Adding random delay (5-30 seconds) to avoid spam detection...
[2025-01-01 10:00:00] local.INFO: ProcessCommentForAutoReply: Delay completed (15 seconds)
[2025-01-01 10:00:00] local.INFO: ProcessCommentForAutoReply: Sending reply to Facebook for comment: test_comment_001
[2025-01-01 10:00:00] local.INFO: ProcessCommentForAutoReply: Reply message: Cảm ơn bạn đã quan tâm! Vui lòng inbox để được tư vấn chi tiết về giá cả nhé!
[2025-01-01 10:00:00] local.INFO: ProcessCommentForAutoReply: Page ID: [page_id]
[2025-01-01 10:00:00] local.INFO: ProcessCommentForAutoReply: Adding delay of 15 seconds to avoid spam detection...
[2025-01-01 10:00:00] local.INFO: ProcessCommentForAutoReply: Making Facebook API request...
[2025-01-01 10:00:00] local.INFO: ProcessCommentForAutoReply: Facebook API response status: 200
[2025-01-01 10:00:00] local.INFO: ProcessCommentForAutoReply: Facebook API response body: {"id":"reply_id_123"}
[2025-01-01 10:00:00] local.INFO: ProcessCommentForAutoReply: Facebook API response: {"success":true,"response":{"id":"reply_id_123"}}
[2025-01-01 10:00:00] local.INFO: ProcessCommentForAutoReply: Step 4: Saving reply result to database...
[2025-01-01 10:00:00] local.INFO: ProcessCommentForAutoReply: Auto-reply completed successfully!
```

## 4. Test các trường hợp đặc biệt

### 4.1 Test comment không cần reply
```bash
php artisan tinker

>>> $campaignAnalytics = App\Models\Dashboard\CampaignTracking\CampaignAnalytics::create([
...     'campaign_id' => 1,
...     'ad_schedule_id' => 1,
...     'comments_data' => [
...         [
...             'id' => 'test_spam_001',
...             'message' => 'http://spam-link.com',
...             'from_user' => ['name' => 'Spam User'],
...             'like_count' => 0,
...             'created_time' => '2025-01-01T00:00:00Z'
...         ]
...     ]
... ]);
```

### 4.2 Test comment khen ngợi
```bash
>>> $campaignAnalytics = App\Models\Dashboard\CampaignTracking\CampaignAnalytics::create([
...     'campaign_id' => 1,
...     'ad_schedule_id' => 1,
...     'comments_data' => [
...         [
...             'id' => 'test_praise_001',
...             'message' => 'Sản phẩm rất tốt, cảm ơn shop!',
...             'from_user' => ['name' => 'Happy Customer'],
...             'like_count' => 5,
...             'created_time' => '2025-01-01T00:00:00Z'
...         ]
...     ]
... ]);
```

### 4.3 Test comment khiếu nại
```bash
>>> $campaignAnalytics = App\Models\Dashboard\CampaignTracking\CampaignAnalytics::create([
...     'campaign_id' => 1,
...     'ad_schedule_id' => 1,
...     'comments_data' => [
...         [
...             'id' => 'test_complaint_001',
...             'message' => 'Sản phẩm tệ quá, lừa đảo!',
...             'from_user' => ['name' => 'Angry Customer'],
...             'like_count' => 0,
...             'created_time' => '2025-01-01T00:00:00Z'
...         ]
...     ]
... ]);
```

## 5. Test retry failed replies

### 5.1 Tạo reply failed để test retry
```bash
php artisan tinker

>>> $reply = new App\Models\Dashboard\CampaignTracking\CommentAutoReply();
>>> $reply->comment_id = 'test_comment_001';
>>> $reply->reply_text = 'Test reply';
>>> $reply->status = 'failed';
>>> $reply->retry_count = 0;
>>> $reply->save();
```

### 5.2 Chạy command retry
```bash
php artisan auto-reply:retry-failed --limit=5
```

**Expected output:**
```
Starting retry process for failed replies (limit: 5)...
Found 1 failed replies to retry.
Getting analysis for comment: test_comment_001
Getting campaign analytics for comment: test_comment_001
Sending retry reply to Facebook for comment: test_comment_001
Retry count incremented for comment: test_comment_001
Retry completed for comment: test_comment_001, status: SUCCESS
Successfully retried reply for comment: test_comment_001
Retry process completed. Success: 1, Failed: 0
```

## 6. Kiểm tra kết quả trong database

### 6.1 Kiểm tra CommentAiAnalysis
```bash
php artisan tinker

>>> App\Models\Dashboard\CampaignTracking\CommentAiAnalysis::all()->toArray();
```

### 6.2 Kiểm tra CommentAutoReply
```bash
>>> App\Models\Dashboard\CampaignTracking\CommentAutoReply::all()->toArray();
```

### 6.3 Kiểm tra thống kê
```bash
>>> $service = new App\Services\Dashboard\CampaignTracking\AutoReplyService();
>>> $stats = $service->getReplyStatistics();
>>> print_r($stats);
```

## 7. Debug các lỗi thường gặp

### 7.1 Python Microservice không chạy
```bash
# Kiểm tra Python service
curl http://localhost:8001/
# Nếu không có response, kiểm tra terminal đang chạy Python service

# Kiểm tra port có bị chiếm dụng
netstat -an | grep 8001
```

### 7.2 Gemini API không hoạt động
```bash
# Kiểm tra API Key
php artisan tinker
>>> config('services.gemini.api_key')
# Nếu null, kiểm tra .env file

# Test API trực tiếp
>>> $trait = new class { use App\Traits\GeminiApiTrait; };
>>> $result = $trait->callGeminiApi("Test prompt");
>>> print_r($result);
```

### 7.3 Facebook API không hoạt động
```bash
# Kiểm tra page_access_token
>>> $userPage = App\Models\Facebook\UserPage::first();
>>> $userPage->page_access_token
# Nếu null, cần cập nhật token

# Test Facebook API trực tiếp
curl -X POST "https://graph.facebook.com/v25.0/{comment_id}/comments" \
  -d "message=Test reply" \
  -d "access_token={page_access_token}"
```

### 7.4 Queue không xử lý
```bash
# Kiểm tra Redis
redis-cli ping
# Nếu không có response "PONG", Redis chưa chạy

# Chạy queue worker
php artisan queue:work --tries=3 --timeout=60 --verbose
```

## 8. Test performance

### 8.1 Test xử lý nhiều comment cùng lúc
```bash
# Tạo nhiều comment để test
>>> for($i=1; $i<=100; $i++) {
...     $comments[] = [
...         'id' => "test_comment_$i",
...         'message' => "Test message $i",
...         'from_user' => ['name' => "User $i"],
...         'like_count' => 0,
...         'created_time' => '2025-01-01T00:00:00Z'
...     ];
... }
>>> $campaignAnalytics = App\Models\Dashboard\CampaignTracking\CampaignAnalytics::create([
...     'campaign_id' => 1,
...     'ad_schedule_id' => 1,
...     'comments_data' => $comments
... ]);
```

### 8.2 Theo dõi thời gian xử lý
```bash
# Chạy command và đo thời gian
time php artisan auto-reply:comments
```

## 9. Test cron job

### 9.1 Test cron job command
```bash
# Test command có hoạt động không
php artisan auto-reply:comments --help

# Test dry-run (nếu có)
php artisan auto-reply:comments --dry-run
```

### 9.2 Cấu hình cron job
```bash
# Thêm vào crontab
crontab -e

# Thêm dòng sau:
*/5 * * * * php /path/to/your/project/artisan auto-reply:comments >> /path/to/your/project/storage/logs/cron.log 2>&1
```

## 10. Test log và monitoring

### 10.1 Kiểm tra log file
```bash
# Theo dõi log real-time
tail -f storage/logs/laravel.log

# Tìm log specific
grep "ProcessCommentForAutoReply" storage/logs/laravel.log
```

### 10.2 Test log level
```bash
# Test các level log khác nhau
>>> Log::debug('Debug message');
>>> Log::info('Info message');
>>> Log::warning('Warning message');
>>> Log::error('Error message');
```

## 11. Test edge cases

### 11.1 Comment không có ID hoặc message
```bash
>>> $campaignAnalytics = App\Models\Dashboard\CampaignTracking\CampaignAnalytics::create([
...     'campaign_id' => 1,
...     'ad_schedule_id' => 1,
...     'comments_data' => [
...         [
...             'id' => 'test_invalid_001',
...             'message' => null,
...             'from_user' => ['name' => 'Test User'],
...             'like_count' => 0,
...             'created_time' => '2025-01-01T00:00:00Z'
...         ],
...         [
...             'message' => 'Test message without ID',
...             'from_user' => ['name' => 'Test User'],
...             'like_count' => 0,
...             'created_time' => '2025-01-01T00:00:00Z'
...         ]
...     ]
... ]);
```

### 11.2 Comment data không phải array
```bash
>>> $campaignAnalytics = App\Models\Dashboard\CampaignTracking\CampaignAnalytics::create([
...     'campaign_id' => 1,
...     'ad_schedule_id' => 1,
...     'comments_data' => 'invalid_string_data'
... ]);
```

### 11.3 Campaign analytics không tồn tại
```bash
>>> $campaignAnalytics = App\Models\Dashboard\CampaignTracking\CampaignAnalytics::create([
...     'campaign_id' => 999, // ID không tồn tại
...     'ad_schedule_id' => 999, // ID không tồn tại
...     'comments_data' => [
...         [
...             'id' => 'test_missing_001',
...             'message' => 'Test message',
...             'from_user' => ['name' => 'Test User'],
...             'like_count' => 0,
...             'created_time' => '2025-01-01T00:00:00Z'
...         ]
...     ]
... ]);
```

## 12. Tổng kết test

Sau khi hoàn thành các bước test trên, hệ thống auto-reply comment của bạn đã được:

1. ✅ **Test từng component riêng lẻ**: Python microservice, Gemini API, Facebook API
2. ✅ **Test toàn bộ flow**: Từ khi có comment mới đến khi reply thành công
3. ✅ **Test các trường hợp đặc biệt**: Comment không cần reply, comment spam, comment khiếu nại
4. ✅ **Test retry mechanism**: Xử lý các reply thất bại
5. ✅ **Test performance**: Xử lý nhiều comment cùng lúc
6. ✅ **Test cron job**: Tự động chạy định kỳ
7. ✅ **Test logging**: Theo dõi và debug hệ thống
8. ✅ **Test edge cases**: Các trường hợp ngoại lệ

Hệ thống đã sẵn sàng để chạy production! 🚀