# TÀI LIỆU KỸ THUẬT: AI Marketer Pro – Giải pháp chuyển đổi số toàn diện cho doanh nghiệp trong quản trị Marketing thông minh dựa trên trí tuệ nhân tạo và phân tích dữ liệu

## 1. Tổng quan hệ thống (Overview)
- **Mục tiêu dự án:** Trở thành một nền tảng Marketing tự động hóa (All-in-one Marketing Platform) được trợ lực bởi AI.
- **Vấn đề giải quyết:** Xóa bỏ sự thủ công lặp đi lặp lại của các công đoạn Marketing truyền thống. Hệ thống giúp người dùng tự động nghiên cứu thị trường, tự sản xuất nội dung (Text, Image, Video), đặt lịch xuất bản hàng loạt và tự động cấu hình chatbot AI trả lời tương tác của khách hàng.
- **Đối tượng sử dụng:** Các Marketer, quản trị viên trang mạng xã hội (Facebook admin), hoặc doanh nghiệp cần một công cụ thống nhất cho chiến dịch trực tuyến.

---

## 2. Công nghệ sử dụng (Tech Stack)

### 🖥️ Frontend (Giao diện người dùng)
Hệ thống tiếp cận dưới dạng **Server-Side Rendering (SSR)** truyền thống nhưng linh hoạt:
- **Blade Templates (PHP)** dùng để phân chia UI.
- **Tailwind CSS & Flowbite** để xây dựng giao diện UI dashboard chuyên nghiệp, hiện đại và Responsive.
- **Alpine.js** cung cấp reactivity linh hoạt, gắn liền với DOM giúp code sáng sủa thiết lập state rườm rà.
- **Vite.js** tối ưu và đóng gói Frontend assets.

### ⚙️ Backend (Máy chủ xử lý chính)
- **Framework Core:** **Laravel 12.0 (PHP 8.2)** đóng vai trò là API gateway, Routing, Background Jobs và điều khiển luồng Business Logic (Services).
- **Packages chính:** 
  - `spatie/laravel-permission`: Phân quyền người dùng.
  - `barryvdh/laravel-dompdf` & `phpoffice/phpword`: Xuất báo cáo thị trường PDF/Word.
  - `laravel/socialite`: Liên kết nền tảng mạng xã hội.
  - `cloudinary_php`: Lưu trữ/xử lý hình ảnh và video trên Cloud.

### 🤖 AI Microservice (Xử lý Machine Learning / NLP)
- **Framework:** **Python + FastAPI** (đặt trong thư mục `/python_microservice`). 
- **Vai trò:** Hoạt động dưới dạng máy chủ ẩn độc lập (cổng 8001). Chuyên phân tích nhận dạng văn bản (NLP) và xử lý ý định (Intent) từ Comments tránh gây tác động lên máy chủ Laravel chính.

### 🗄️ Database & Storage 
- **Database:** Relational Database tiêu chuẩn (MySQL/MariaDB hoặc SQLite).
- **Cache & Queue Broker:** **Redis** phân phối các luồng chạy ẩn nền đồng thời (Background jobs).

---

## 3. Kiến trúc hệ thống (Architecture)
- **Mô hình triển khai:** **Microservices-Lite** (kết hợp Monolith Backend Core và Microservice Python AI). Code được tổ chức theo **Service & Repository Pattern** (`app/Services`, `app/Repositories`).
- **Luồng dữ liệu và Đồng bộ AI:** Các tác vụ cực nặng (Làm Report, Phân tích text) được ném vào **Background Queues/Jobs**. Các Job Worker (Laravel) chạy ẩn gọi API (HTTP Request) sang cổng của Python, chờ kết quả, sau đó gọi mô hình GenAI, cuối cùng lưu lại DB để không bao giờ Block (treo) giao diện phía User.

---

## 4. Phân tích chi tiết các chức năng cốt lõi (Technical Deep-Dive)

Hệ thống được thiết kế theo vòng khép kín của một công ty Agency Marketing bao gồm 4 khối phòng ban:

### A. Nghiên cứu Thị trường (Market Research Intelligence)
Việc nghiên cứu thị trường dựa chủ yếu vào logic định kỳ của Job `GenerateMarketReportJob.php` bao gồm 4 giai đoạn đồ sộ:
1. **Thu thập dữ liệu thực:** Hệ thống gọi API của `SerpApi` để cào 3 tập dữ liệu của Google bao gồm Organic Search, Google Shopping (khoảng giá) và Google Trends (lượt quan tâm theo thời gian).
2. **Nhận định tính (Python Quantitative):** Chuyển JSON Raw về `python_microservice` (/api/v1/market-research/analyze) xử lý đo đếm biên độ kỹ thuật, sự dao động của trend.
3. **Sinh Báo Cáo Định Tính (Qualitative GenAI):** Gửi Prompt (kèm Context + Giá + Trend) cho Gemini API sắm vai Giám đốc Chiến lược (Head of Insights) ráp nối dữ liệu trả về 1 JSON bắt buộc theo Format chuẩn (Gồm: Mô hình SWOT, Customer Persona, Action plan).
4. **Đóng kết quả:** Formating tạo Chart và xuất các báo cáo ra bảng Dashboard (Cho phép Export Word/PDF).

### B. Xưởng Nội Dung Không Giới Hạn (Content Creator)
Logic nghiệp vụ tại `VideoController` và `BackgroundRemovalController`.
- **Image AI:** Xóa và ghép nền hình ảnh sản phẩm.
- **Video API Suite:** API trực tiếp hỗ trợ (qua FFmpeg/Cloudinary) gồm Trim, ghép mảng Clip (Merge), bộ lọc màu (Filter), đóng watermark, kéo chữ (Text), nén định dạng (Resize) và tách âm thanh ra khỏi video.

### C. Vận hành Chiến dịch (Campaign Tracking & Auto Publisher)
Hoạt động thông qua nhánh `AutoPublisher` và `CampaignTrackingController`.
- **Auto Publisher:** Quản trị chiến dịch (Campaign) và Lịch xuất bản `ad_schedule` tự động đăng bài hẹn thời gian thông qua các Token Pages MXH tích hợp sẵn.
- **Campaign Tracking:** Frontend dùng vòng lặp định kỳ (AJAX Polling API `api/stats`) bám đuổi cập nhật Data. Cho phép tạm dừng (Pause), Tiếp tục (Resume) các quảng cáo nếu thất thoát kinh phí.

### D. Tương tác AI Đa chiều (AI Comment Auto-Reply)
Luồng chuyển hóa Comment từ người dùng thành đoạn tương tác bán hàng trên `ProcessCommentForAutoReply.php`.
- **Cơ chế Webhook:** Facebook gọi về. Event lưu text thô vào `post_comments`.
- **Hệ thống lọc thông minh:** Gửi dữ liệu tới Python. Python sẽ định mệnh Tag (Ví dụ: Hỏi Giá (90%), Than phiền (95%)) và quyết định cơ chế `should_reply` để hệ thống không đi trả lời các spam của bot khác.
- **Trở thành nhân viên CSKH (Gemini Prompt):** Đẩy cái Tag NLP kia vào Gemini kèm với "Nội dung Post Gốc mà Khách Hàng vừa Comment để lấy Ngữ cảnh". Gemini sẽ viết bài Response phản biện lại 1 cách thân thiện.
- **Kỹ thuật chống shadow-ban:** Trước khi Gọi Request gửi lên Facebook Graph API, `sleep(rand(5, 30))` để giả vờ giống nhịp độ đánh máy người thật. Kết quả chốt hạ lưu vào `comment_auto_replies`.

---

## 5. Cấu trúc Database cốt lõi

- **Quản trị người dùng:** `users`, bảng ủy quyền `permission_tables`, và bảng định danh `user_pages` (liên kết Fanpage FB UID).
- **Core Entity:**
   - `products`: Chứa input mặt hàng đầu vào.
   - `campaigns`, `ad_schedule`: Chiến dịch quảng cáo.
   - `campaign_analytics`: Hệ thống Tracking hiệu quả tổng.
   - `ads`, `ad_images`, `videos`: Kho chứa media asset của riêng Marketers.
   - `ai_settings`: Lưu profile ngữ cảnh cho AI.
- **Log AI Tương Tác:**
  - `post_comments`: Log comment dạng text thô.
  - `comment_ai_analysis`: Bảng tính toán xác suất (Tag + Tỷ lệ % tự tin) do Python NLP bóc tách ra.
  - `comment_auto_replies`: Lưu chữ bản thân hệ thống dự tính reply lại với trạng thái Success/Failed.

---

## 6. Hướng dẫn cài đặt và Deployment

**Bước 1: Cài đặt Hệ sinh thái PHP & Laravel**
1. Mở Cửa sổ Terminal. Cài package: `composer install` & `npm install`.
2. Tạo file môi trường: Copy `.env.example` -> `.env`. Cấu hình kết nối MySQL và thông số Redis (Rất Quan Trọng đối với Queue).
3. Tạo key và Khởi tạo database: `php artisan key:generate` và `php artisan migrate --seed`
4. Deploy giao diện Frontend: `npm run dev` (hoặc build production `npm run build`).
5. Kích hoạt Backend Worker: `php artisan queue:listen` (Nếu không bật Terminal này, toàn bộ tính năng tự động sẽ bị liệt).

**Bước 2: Cài đặt Python Microservices AI**
1. Bật Session Terminal thứ 2, trỏ vào thư mục: `cd python_microservice`
2. Cài environment python: `pip install -r requirements.txt`
3. Kích hoạt Microservice uvicorn: `python main.py` (Mặc định sẽ gắn tại Port HTTP 8001).
*(Nếu sử dụng Docker, chỉ cần thiết lập thông qua file docker-compose.yml có sẵn là boot được khối Python)*.

---

## 7. Đánh giá hệ thống và Ưu điểm kiến trúc
- Việc tách nghiệp vụ Phân tích ngôn ngữ AI bằng Regex sang Microservice độc lập sử dụng Python là một Setup đạt tiêu chuẩn công nghiệp (Làm nền móng để Scale Server, tích hợp Deep Learning sau này). Laravel khi đó hoạt động hoàn toàn linh hoạt mà không bị kẹt bộ nhớ RAM.
- Hệ thống giải quyết trọn vẹn cả quá trình: Nghiên cứu, Sản Xuất, Phân Phối và Hỗ trợ Sau bán cho Marketing Agent.
- Việc Setup Code Service Oriented và Queue Background Job tránh làm nghẽn giao diện cho UI mang lại sự chuyên nghiệp. 

*Tài liệu được phân tích dựa trên Data Flow Engine và Code thực tế của Source AI Marketer Pro.*
