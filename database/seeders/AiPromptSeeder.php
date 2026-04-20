<?php

namespace Database\Seeders;

use App\Models\Dashboard\AiPrompt;
use Illuminate\Database\Seeder;

class AiPromptSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $prompts = [
      [
        'slug' => 'market-research-strategic',
        'name' => 'Báo cáo Chiến lược Thị trường (Market Research)',
        'group' => 'market_research',
        'role' => 'Giám đốc Tư vấn Chiến lược Market Research hàng đầu (Head of Insights)',
        'content' => "Dựa trên tất cả dữ liệu thực tế và phân tích của hệ thống AI, hãy tạo báo cáo chiến lược thị trường toàn diện bằng Tiếng Việt.

### THÔNG TIN SẢN PHẨM KHÁCH HÀNG
- Tên sản phẩm: {product_name}
- Ngành hàng: {industry}
- Mô tả: {description}
- Độ tuổi mục tiêu: {age_range}
- Thu nhập mục tiêu: {income_level}
- Sở thích KH: {interests}
- Đối thủ cào được:
{competitors}

### KẾT QUẢ PHÂN TÍCH SỐ LIỆU TỪ HỆ THỐNG
- Xu hướng 6 tháng tới (Google Trends Prophet Model): {trend_direction} (Tốc độ tăng trưởng dự báo: {growth_rate}%)
- Khoảng giá thị trường đối thủ (Google Shopping): {price_min} VNĐ đến {price_max} VNĐ
- Sentiment thị trường: {sentiment}

### YÊU CẦU BÁO CÁO CHUẨN JSON
Hãy trả lời CẤU TRÚC JSON CHÍNH XÁC NHƯ SAU (chỉ trả json, không thêm markdowns code blocks hay note gì cả, bắt buộc format phải parse được bằng json_decode của PHP):
{
  \"executive_summary\": \"Tóm tắt chiến lược điều hành (managerial summary)...\",
  \"market_overview\": {
     \"market_size\": \"...\",
     \"addressable_market\": \"...\",
     \"cagr\": \"...\",
     \"key_trends\": [\"trend 1\", \"trend 2\"],
     \"market_maturity\": \"growth hoặc mature...\"
  },
  \"customer_persona\": [
      {
          \"name\": \"...\",
          \"age\": 25,
          \"income\": \"...\",
          \"behavior\": \"...\",
          \"pain_points\": [\"pain 1\"],
          \"motivations\": [\"motiv 1\"]
      }
  ],
  \"competitor_analysis\": {
      \"summary\": \"...\",
      \"competitors\": [
          {
             \"name\": \"...\",
             \"market_position\": \"...\",
             \"strengths\": [\"str 1\"],
             \"weaknesses\": [\"weak 1\"],
             \"pricing_strategy\": \"...\"
          }
      ],
      \"market_gap\": \"Khoảng trống thị trường mà chúng ta có thể nhảy vào\"
  },
  \"swot_analysis\": {
      \"strengths\": [\"\"],
      \"weaknesses\": [\"\"],
      \"opportunities\": [\"\"],
      \"threats\": [\"\"]
  },
  \"pricing_strategy\": {
      \"recommended_strategy\": \"...\",
      \"recommended_price_range\": \"...\",
      \"rationale\": \"Lý do...\",
      \"pricing_tiers\": [
          { \"tier\": \"Entry\", \"price_range\": \"...\", \"products\": \"...\"}
      ]
  },
  \"go_to_market_strategy\": {
      \"primary_channels\": [\"\"],
      \"launch_message\": \"\",
      \"content_pillars\": [\"\"]
  },
  \"action_plan\": {
      \"phase_1_30_days\": [\"\"],
      \"phase_2_60_days\": [\"\"],
      \"phase_3_90_days\": [\"\"]
  }
}",
        'notes' => 'Prompt dùng để tạo báo cáo nghiên cứu thị trường chi tiết từ dữ liệu SerpApi và Python Analysis.'
      ],
      [
        'slug' => 'comment-reply-standard',
        'name' => 'Phản hồi bình luận tự động (Comment Reply)',
        'group' => 'comment_reply',
        'role' => 'Chuyên viên chăm sóc khách hàng chuyên nghiệp',
        'content' => "Hãy viết câu trả lời cho comment sau bằng tiếng Việt, ngắn gọn 1-3 câu, thân thiện và có thể chốt sale nhẹ nếu phù hợp.

{context}
Comment cần trả lời: \"{message}\"

Sentiment: {sentiment}
Type: {type}

Hãy trả lời bằng tiếng Việt, không giải thích, chỉ trả về nội dung câu trả lời dưới dạng JSON: {\"reply\": \"nội dung trả lời\"}",
        'notes' => 'Prompt dùng để phản hồi bình luận khách hàng trên Facebook.'
      ],
      [
        'slug' => 'content-creator-product',
        'name' => 'Sáng tạo nội dung từ Sản phẩm (Content Creator)',
        'group' => 'content_creator',
        'role' => 'Chuyên gia Marketing & Copywriting với 10+ năm kinh nghiệm',
        'content' => "NHIỆM VỤ: Tạo bài đăng content marketing chuyên nghiệp, hấp dẫn và có tính thuyết phục cao.

📊 THÔNG TIN SẢN PHẨM/DỊCH VỤ:
- Tên: {name}
- Ngành: {industry}
- Mô tả chi tiết: {description}

🎯 PHÂN TÍCH KHÁCH HÀNG MỤC TIÊU:
- Độ tuổi: {age_range}
- Mức thu nhập: {income_level}
- Sở thích & hành vi: {interests}

🔍 BỐI CẢNH THỊ TRƯỜNG:
- Danh sách đối thủ: 
{competitors}
→ Hãy tìm góc độ khác biệt, tạo lợi thế cạnh tranh mà KHÔNG nhắc trực tiếp tên đối thủ

⚙️ YÊU CẦU KỸ THUẬT:
- Platform: {platform}
- Ngôn ngữ: {language}
- Tone of voice: {tone}
- Độ dài: {length}

📝 HƯỚNG DẪN VIẾT:

1. TIÊU ĐỀ (ad_title):
- Hook mạnh mẽ, gây tò mò hoặc chạm pain point
- Dài 40-60 ký tự cho {platform}
- Chứa từ khóa liên quan đến {industry}

2. NỘI DUNG (ad_content):
- MỞ ĐẦU: Đặt câu hỏi/thống kê/câu chuyện liên quan đến pain point của nhóm khách hàng {age_range}, thu nhập {income_level}
- THÂN BÀI: 
    * Làm nổi bật 2-3 lợi ích cốt lõi từ {description}
    * Kết nối với sở thích {interests}
    * Sử dụng social proof/số liệu nếu phù hợp
- KẾT THÚC: CTA rõ ràng, tạo cảm giác khan hiếm/cấp bách

3. HASHTAGS:
- 5-8 hashtags phù hợp với {platform}
- Mix giữa: hashtag ngành ({industry}), trending, branded
- Phân tích bối cảnh thị trường để tìm từ khóa ngách

4. EMOJIS:
- 3-5 emoji phù hợp tone {tone}
- Đặt ở vị trí chiến lược để tăng engagement

🎨 NGUYÊN TẮC SÁNG TẠO:
✓ Viết theo phong cách storytelling nếu tone cho phép
✓ Tối ưu cho thuật toán {platform} (engagement rate, dwell time)
✓ Cá nhân hóa theo insight khách hàng ({interests})
✓ Tạo khác biệt với cách tiếp cận của đối thủ
✗ KHÔNG so sánh trực tiếp, hạ thấp đối thủ
✗ KHÔNG dùng ngôn ngữ chung chung, mờ nhạt

{
    \"ad_title\": \"Tiêu đề hook mạnh mẽ\",
    \"ad_content\": \"Nội dung đầy đủ với cấu trúc rõ ràng, xuống dòng hợp lý\",
    \"hashtags\": \"#hashtag1 #hashtag2 #hashtag3\",
    \"emojis\": \"🎯💡✨\"
}

Lưu ý: Trả về đúng định dạng JSON, không có Markdown, không có dấu ** hoặc ký hiệu đặc biệt nào.",
        'notes' => 'Prompt dùng để tạo nội dung quảng cáo từ thông tin sản phẩm.'
      ],
      [
        'slug' => 'content-creator-link',
        'name' => 'Tái cấu trúc nội dung từ Link (Content Creator)',
        'group' => 'content_creator',
        'role' => 'Chuyên gia Content Repurposing & Social Media Marketing hàng đầu',
        'content' => "NHIỆM VỤ: Phân tích nội dung từ URL và chuyển hóa thành bài đăng mạng xã hội viral, giữ nguyên giá trị thông tin nhưng tối ưu engagement.

🔗 NGUỒN THAM KHẢO: {link}

Bước 1: HÃY TRUY CẬP VÀ PHÂN TÍCH LINK
- Đọc kỹ toàn bộ nội dung
- Xác định: key message, insight chính, góc nhìn độc đáo
- Trích xuất: số liệu, quotes, case study (nếu có)

Bước 2: TÁI CẤU TRÚC CHO {platform}

⚙️ THÔNG SỐ KỸ THUẬT:
- Platform: {platform}
- Ngôn ngữ: {language}  
- Tone of voice: {tone}
- Độ dài: {length}

📝 YÊU CẦU NỘI DUNG:

1. TIÊU ĐỀ (ad_title):
- Đúc kết key message của link thành hook thu hút
- Phù hợp định dạng {platform} và tone {tone}
- Dài 40-60 ký tự, chứa từ khóa chính

2. NỘI DUNG (ad_content):
- MỞ ĐẦU: 
    * Pattern interrupt - làm người đọc dừng scroll
    * Có thể dùng câu hỏi/thống kê/micro-story từ link

- THÂN BÀI:
    * Tổng hợp 2-3 điểm giá trị nhất từ link
    * Viết lại bằng ngôn ngữ {language}, tone {tone}
    * Thêm insight/góc nhìn cá nhân nếu phù hợp
    * Format dễ đọc trên mobile (đoạn ngắn, bullet points nếu cần)

- KẾT THÚC:
    * CTA phù hợp với mục đích bài viết
    * Khuyến khích tương tác (comment, share, click link)

3. HASHTAGS:
- 5-8 hashtags dựa trên chủ đề link
- Mix: niche hashtags (low competition) + popular hashtags
- Research trending hashtags liên quan trên {platform}

4. EMOJIS:
- 3-6 emoji phù hợp với tone {tone} và nội dung
- Sử dụng để phân tách đoạn, tạo visual break

🎯 NGUYÊN TẮC CHUYỂN HÓA:
✓ GIỮ: Thông tin chính xác, giá trị cốt lõi, insight từ link
✓ THAY ĐỔI: Cấu trúc, góc kể chuyện, examples, diễn đạt 100%
✓ TỐI ƯU: Cho thuật toán {platform} (keywords, engagement hooks)
✓ CÁ NHÂN HÓA: Theo tone {tone} và đặc thủ {platform}
✗ KHÔNG copy-paste câu văn nguyên gốc
✗ KHÔNG làm mất đi độ chính xác thông tin
✗ KHÔNG viết quá dài dòng, lan man

{
    \"ad_title\": \"Tiêu đề tái cấu trúc từ key message của link\",
    \"ad_content\": \"Nội dung hoàn chỉnh với cấu trúc rõ ràng, xuống dòng hợp lý\",
    \"hashtags\": \"#hashtag1 #hashtag2 #hashtag3\",
    \"emojis\": \"💡🔥🚀\"
}

Lưu ý: Trả về đúng định dạng JSON, không có Markdown, không có dấu ** hoặc ký hiệu đặc biệt nào.",
        'notes' => 'Prompt dùng để chuyển đổi nội dung từ một liên kết web thành bài đăng mạng xã hội.'
      ]
    ];

    foreach ($prompts as $prompt) {
      AiPrompt::updateOrCreate(['slug' => $prompt['slug']], $prompt);
    }
  }
}
