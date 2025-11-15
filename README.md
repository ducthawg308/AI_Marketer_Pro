<p align="center">
  <a href="https://github.com/yourusername/AI-Marketer-Pro" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="200" alt="Laravel Logo">
  </a>
</p>

<h1 align="center">🤖 AI Marketer Pro</h1>

<p align="center">
  Giải pháp chuyển đổi số toàn diện cho doanh nghiệp trong lĩnh vực Marketing — kết hợp sức mạnh của Trí tuệ nhân tạo (AI) và Tự động hóa (Automation).
</p>

<p align="center">
  <a href="#"><img src="https://img.shields.io/badge/Laravel-12.x-red" alt="Laravel Version"></a>
  <a href="#"><img src="https://img.shields.io/badge/AI-Gemini%20API-blue" alt="Gemini API"></a>
  <a href="#"><img src="https://img.shields.io/badge/Status-In%20Development-yellow" alt="Status"></a>
  <a href="#"><img src="https://img.shields.io/badge/License-MIT-green" alt="License"></a>
</p>

---

🚀 Giới thiệu

AI Marketer Pro là nền tảng AI Marketing Automation Platform giúp doanh nghiệp:
- Hiểu rõ đối tượng mục tiêu
- Nghiên cứu thị trường tự động bằng AI
- Sinh content thông minh theo chiến lược thương hiệu
- Lên lịch đăng bài và quản lý chiến dịch đa kênh
- Theo dõi hiệu suất chiến dịch, đưa ra gợi ý tối ưu hóa

Tất cả được thực hiện trên một giao diện duy nhất — thân thiện, nhanh, và mạnh mẽ.  
AI Marketer Pro giúp doanh nghiệp chuyển đổi số trong hoạt động marketing, giảm 80% thời gian thủ công và tăng hiệu suất đội ngũ gấp 3 lần.

---

🧩 Tính năng chính

1️⃣ Khởi tạo đối tượng mục tiêu
- Xây dựng chân dung khách hàng (persona) thông minh  
- Cấu hình các đặc điểm như độ tuổi, giới tính, sở thích, hành vi, khu vực, nhu cầu  
- Là tiền đề cho toàn bộ các chức năng nghiên cứu và tạo nội dung

2️⃣ Nghiên cứu thị trường (AI Market Research)
- Dựa trên dữ liệu cấu hình, AI sẽ phân tích theo 3 hướng:
  - Phân tích người tiêu dùng  
  - Phân tích đối thủ cạnh tranh  
  - Xu hướng thị trường
- Cho phép xuất báo cáo tự động (PDF, DOCX) có thể trình bày cho lãnh đạo hoặc khách hàng

3️⃣ Khởi tạo nội dung (AI Content Creator)
- Sinh nội dung đa dạng theo 3 cách:
  - Nhập thủ công
  - Sinh dựa vào đối tượng mục tiêu
  - Sinh từ link bài viết hoặc nguồn tham chiếu  
- Hỗ trợ nhiều định dạng: bài đăng mạng xã hội, blog, email, video script,...

4️⃣ Trung tâm đăng bài (Post Center)
- Tích hợp Facebook Graph API để:
  - Đăng bài hoặc lên lịch tự động  
  - Quản lý chiến dịch và bài viết trên nhiều fanpage  
- Sắp tới hỗ trợ thêm Instagram, TikTok, Zalo OA, LinkedIn

5️⃣ Theo dõi chiến dịch (Campaign Monitor)
- Thống kê lượt tiếp cận, tương tác, CTR, hiệu quả chiến dịch  
- AI tự động đánh giá hiệu suất nội dung và đề xuất cải thiện chiến lược  
- Báo cáo trực quan bằng biểu đồ và dashboard

---

🧠 Định hướng phát triển

Trong các phiên bản sắp tới, hệ thống sẽ tích hợp thêm:
- AI Campaign Planner – Trợ lý lập kế hoạch marketing tự động  
- Competitor Tracker Dashboard – Theo dõi đối thủ theo thời gian thực  
- AI Content Scoring – Đánh giá mức độ hấp dẫn và hiệu quả nội dung  
- Multi-Platform Scheduler – Đăng đa nền tảng và tự động chọn thời điểm tối ưu  
- Marketing Automation Workflow – Cho phép người dùng tạo luồng hành động (if–then)

---

🧱 Công nghệ sử dụng

| Thành phần | Công nghệ |
|-------------|------------|
| Backend | Laravel 12.x (PHP 8.4) |
| Frontend | Blade, HTML, CSS, JS + TailwindCSS, Flowbite Tailwind |
| Database | MySQL / PostgreSQL |
| AI Engine | Gemini API (Google AI Studio) |
| Social Integration | Facebook Graph API (sắp tới: TikTok, Instagram, Zalo OA) |
| Scheduler & Queue | Laravel Horizon / Redis |
| Authentication | Laravel Breeze + OAuth2 |

---

🛠️ Cài đặt & Khởi chạy

```bash
# Clone dự án
git clone https://github.com/yourusername/AI-Marketer-Pro.git

cd AI-Marketer-Pro

# Cài đặt gói PHP
composer install

# Cài đặt gói JS
npm install && npm run dev

# Tạo file môi trường
cp .env.example .env

# Cấu hình database và AI API key trong .env
php artisan key:generate
php artisan migrate --seed

# Chạy ứng dụng
php artisan serve
