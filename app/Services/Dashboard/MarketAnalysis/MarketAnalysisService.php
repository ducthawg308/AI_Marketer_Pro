<?php

namespace App\Services\Dashboard\MarketAnalysis;

use App\Traits\GeminiApiTrait;
use Illuminate\Support\Str;

use App\Models\Dashboard\AudienceConfig\Product;
use App\Repositories\Interfaces\Dashboard\MarketAnalysis\MarketAnalysisInterface;
use App\Services\BaseService;
use App\Services\Dashboard\DataCrawlers\RedditCrawler;
use App\Services\Dashboard\DataCrawlers\YouTubeCrawler;
use App\Services\Dashboard\DataCrawlers\NewsAPICrawler;
use App\Services\Dashboard\DataCrawlers\GoogleTrendsCrawler;
use Illuminate\Support\Facades\Log;

class MarketAnalysisService extends BaseService
{
    use GeminiApiTrait;

    public function __construct(private MarketAnalysisInterface $marketAnalysisRepository) {}

    public function create($attributes)
    {
        return $this->marketAnalysisRepository->create($attributes);
    }

    public function analysis($attributes)
    {
        $productId = $attributes['product_id'] ?? null;
        $product = Product::find($productId);
        if (!$product) {
            return ['success' => false, 'error' => 'Product not found'];
        }

        // ----- 1. Crawl dữ liệu từ nhiều nguồn miễn phí -----
        $googleTrendsCrawler = new GoogleTrendsCrawler();
        $redditCrawler = new RedditCrawler();
        $youtubeCrawler = new YouTubeCrawler();
        $newsCrawler = new NewsAPICrawler();

        Log::info("Bắt đầu crawl dữ liệu cho: {$product->name}");

        // Google Trends Data
        try {
            $googleTrendsData = $googleTrendsCrawler->fetchTrends($product->name, 'VN');
            Log::info('Google Trends data crawled successfully');
        } catch (\Exception $e) {
            Log::error('Google Trends crawl error: ' . $e->getMessage());
            $googleTrendsData = ['success' => false, 'error' => 'Không lấy được dữ liệu Google Trends'];
        }

        // Reddit Data
        try {
            $redditData = $redditCrawler->searchPosts($product->name, 25, 'month');
            Log::info('Reddit data crawled successfully');
        } catch (\Exception $e) {
            Log::error('Reddit crawl error: ' . $e->getMessage());
            $redditData = ['success' => false, 'error' => 'Không lấy được dữ liệu Reddit'];
        }

        // YouTube Data
        try {
            $youtubeData = $youtubeCrawler->searchVideos($product->name, 25, 'VN');
            Log::info('YouTube data crawled successfully');
        } catch (\Exception $e) {
            Log::error('YouTube crawl error: ' . $e->getMessage());
            $youtubeData = ['success' => false, 'error' => 'Không lấy được dữ liệu YouTube'];
        }

        // News Data
        try {
            $newsData = $newsCrawler->searchNews($product->name, 'vi');
            Log::info('News data crawled successfully');
        } catch (\Exception $e) {
            Log::error('News crawl error: ' . $e->getMessage());
            $newsData = ['success' => false, 'error' => 'Không lấy được dữ liệu News'];
        }

        // ----- 2. Định nghĩa các loại prompt -----
        $prompts = [
            'competitor' => "
                Bạn là một chuyên gia phân tích cạnh tranh. Hãy phân tích đối thủ cạnh tranh dựa trên dữ liệu sau:

                THÔNG TIN ĐẦU VÀO:
                🔹 Sản phẩm/Dịch vụ: {$product->name}  
                🔹 Ngành nghề: {$product->industry}  
                🔹 Mô tả sản phẩm: {$product->description}  
                🔹 Đối thủ chính:  
                - Tên: {$product->competitor_name}  
                - Website: {$product->competitor_url}  
                - Mô tả: {$product->competitor_description}  
                🔹 Khoảng thời gian phân tích: {$attributes['start_date']} → {$attributes['end_date']}  

                YÊU CẦU PHÂN TÍCH:
                1. Liệt kê tối thiểu 3 đối thủ tiềm năng khác trên thị trường.  
                2. Đánh giá điểm mạnh và điểm yếu của từng đối thủ dựa trên:  
                - Sản phẩm, dịch vụ  
                - Giá cả  
                - Chiến lược marketing  
                - Thị phần  
                3. Đưa ra gợi ý chiến lược cạnh tranh cụ thể để sản phẩm {$product->name} vượt lên.  
                4. Sử dụng số liệu thực tế và liên quan đến thị trường Việt Nam.  
                5. Định dạng dữ liệu trả về dưới dạng JSON:

                {
                    \"competitors\": [
                        {
                            \"name\": \"Tên đối thủ\",
                            \"url\": \"Website\",
                            \"strengths\": [\"Điểm mạnh 1\", \"Điểm mạnh 2\"],
                            \"weaknesses\": [\"Điểm yếu 1\", \"Điểm yếu 2\"]
                        }
                    ],
                    \"strategy\": [
                        {
                            \"title\": \"Chiến lược đề xuất\",
                            \"content\": \"Mô tả chi tiết và cách thực hiện\"
                        }
                    ]
                }

                Lưu ý: Trả về đúng định dạng JSON, không có Markdown, không có dấu ** hoặc ký hiệu đặc biệt nào.
            ",

            'consumer' => "
                Bạn là chuyên gia phân tích hành vi khách hàng. Hãy phân tích nhóm khách hàng mục tiêu cho sản phẩm dưới đây:

                THÔNG TIN ĐẦU VÀO:
                🔹 Sản phẩm/Dịch vụ: {$product->name}  
                🔹 Ngành nghề: {$product->industry}  
                🔹 Mô tả sản phẩm: {$product->description}  
                🔹 Khoảng thời gian phân tích: {$attributes['start_date']} → {$attributes['end_date']}  
                🔹 Độ tuổi khách hàng hiện tại: {$product->target_customer_age_range}  
                🔹 Mức thu nhập khách hàng hiện tại: {$product->target_customer_income_level}  
                🔹 Sở thích khách hàng hiện tại: {$product->target_customer_interests}  

                YÊU CẦU PHÂN TÍCH:
                1. Xác định rõ độ tuổi, thu nhập, sở thích tiêu biểu của khách hàng mục tiêu.  
                2. Liệt kê hành vi tiêu dùng phổ biến nhất.  
                3. Phân tích các pain points (vấn đề khách hàng thường gặp) liên quan đến sản phẩm/dịch vụ.  
                4. Đưa ra 3-5 chiến lược marketing cụ thể, có thể thực thi, không chung chung.  
                5. Dữ liệu phải sát với thị trường Việt Nam.

                ĐỊNH DẠNG RESPONSE (JSON):
                {
                    \"age_range\": \"Độ tuổi khách hàng mục tiêu\",
                    \"income\": \"Mức thu nhập tiêu biểu\",
                    \"interests\": [\"Sở thích 1\", \"Sở thích 2\"],
                    \"behaviors\": [\"Hành vi 1\", \"Hành vi 2\"],
                    \"pain_points\": [\"Vấn đề 1\", \"Vấn đề 2\"],
                    \"recommendations\": [
                        {
                            \"title\": \"Tên chiến lược marketing\",
                            \"content\": \"Mô tả chi tiết cách thực hiện\"
                        }
                    ]
                }

                Lưu ý: Trả về đúng định dạng JSON, không có Markdown, không có dấu ** hoặc ký hiệu đặc biệt nào.
            ",

            'trend' => "
                Bạn là chuyên gia phân tích thị trường với 15 năm kinh nghiệm trong việc dự báo xu hướng và phát hiện cơ hội mới nổi.

                THÔNG TIN PHÂN TÍCH:
                🔹 Ngành nghề: {$product->industry}
                🔹 Sản phẩm/Dịch vụ: {$product->name}
                🔹 Thị trường mục tiêu: Việt Nam
                🔹 Khoảng thời gian phân tích: {$attributes['start_date']} → {$attributes['end_date']}

                YÊU CẦU PHÂN TÍCH CHUYÊN SÂU:

                1. Phân tích thị trường hiện tại (300-400 từ):
                - Đánh giá quy mô và tốc độ tăng trưởng thị trường
                - Xác định các động lực chính thúc đẩy sự phát triển
                - Phân tích hành vi tiêu dùng và thay đổi nhu cầu
                - Đánh giá cảnh quan cạnh tranh và vị thế các player chính

                2. Dự báo xu hướng 6-12 tháng tới (300-400 từ):
                - Nhận diện 3-5 xu hướng mới nổi cụ thể
                - Dự báo các cơ hội đầu tư và phát triển sản phẩm
                - Cảnh báo rủi ro và thách thức tiềm ẩn
                - Ước tính mức độ tác động của từng xu hướng (Cao/Trung bình/Thấp)

                3. Phân tích SWOT cho ngành:
                - Điểm mạnh (Strengths)
                - Điểm yếu (Weaknesses)
                - Cơ hội (Opportunities)
                - Thách thức (Threats)

                4. Dữ liệu biểu đồ xu hướng (bắt buộc dựa theo khoảng thời gian phân tích):
                - Tạo danh sách tháng theo đúng khoảng thời gian: {$attributes['start_date']} → {$attributes['end_date']}
                - Tuyệt đối không được sinh thêm tháng ngoài phạm vi này.
                - Số lượng điểm dữ liệu phải bằng đúng số tháng trong khoảng thời gian truyền vào.
                - Cho mỗi tháng, tạo:
                    • Market Growth Index (chỉ số tăng trưởng thị trường)
                    • Consumer Interest Index (mức độ quan tâm của người tiêu dùng)
                    • Số liệu thực tế (chỉ áp dụng cho tháng <= tháng hiện tại)
                    • Số liệu dự báo (chỉ áp dụng cho tháng > tháng hiện tại)
                - Nếu khoảng thời gian chỉ có 3 tháng (ví dụ 03/2025 → 05/2025), chỉ được trả về đúng 3 điểm dữ liệu.
                - Dữ liệu phải được mô phỏng hợp lý dựa trên thị trường Việt Nam.

                5. Khuyến nghị chiến lược (5-7 khuyến nghị cụ thể):
                - Chiến lược ngắn hạn (3-6 tháng)
                - Chiến lược trung hạn (6-12 tháng)
                - Chiến lược đầu tư công nghệ và đổi mới
                - Chiến lược marketing và brand positioning
                - Phát triển sản phẩm/dịch vụ mới

                LƯU Ý QUAN TRỌNG:
                - Sử dụng số liệu mô phỏng hợp lý và có thể giải thích được
                - Không đưa thông tin bịa đặt vô căn cứ
                - Không dùng dữ liệu không khớp với khoảng thời gian phân tích
                - Không được nói về việc không có dữ liệu
                - Trả về đúng định dạng JSON, không dùng markdown hay ký tự đặc biệt

                ĐỊNH DẠNG RESPONSE (JSON):
                {
                    \"market_size\": \"Quy mô thị trường hiện tại (VNĐ/USD)\",
                    \"growth_rate\": \"Tốc độ tăng trưởng (%/năm)\",

                    \"analysis\": \"Phân tích thị trường hiện tại chi tiết\",

                    \"emerging_trends\": [
                        {
                            \"trend\": \"Tên xu hướng\",
                            \"impact_level\": \"Cao/Trung bình/Thấp\",
                            \"description\": \"Mô tả chi tiết xu hướng\",
                            \"timeline\": \"Thời gian dự kiến bùng nổ\"
                        }
                    ],

                    \"forecast\": \"Dự báo xu hướng 6-12 tháng tới\",

                    \"swot_analysis\": {
                        \"strengths\": [\"Điểm mạnh 1\", \"Điểm mạnh 2\"],
                        \"weaknesses\": [\"Điểm yếu 1\", \"Điểm yếu 2\"],
                        \"opportunities\": [\"Cơ hội 1\", \"Cơ hội 2\"],
                        \"threats\": [\"Thách thức 1\", \"Thách thức 2\"]
                    },

                    \"chart_data\": {
                        \"labels\": [
                            \"Danh sách tháng được tạo theo đúng start_date → end_date. Không được tạo thêm tháng.\",
                            \"Ví dụ nếu start_date=2025-03 và end_date=2025-05:\",
                            [\"2025-03\", \"2025-04\", \"2025-05\"]
                        ],

                        \"market_growth_index\": [
                            \"Số lượng phần tử phải khớp 100% với labels.\",
                            \"Ví dụ:\",
                            [102, 105, 108]
                        ],

                        \"consumer_interest_index\": [
                            \"Số lượng phần tử phải bằng đúng số tháng.\",
                            \"Ví dụ:\",
                            [88, 92, 95]
                        ],

                        \"actual_data\": [
                            \"Tháng quá khứ hoặc hiện tại → có số liệu.\",
                            \"Tháng tương lai → null.\",
                            \"Ví dụ nếu hiện tại là 04/2025:\",
                            [130, 135, null]
                        ],

                        \"forecast_data\": [
                            \"Tháng tương lai → có dự báo.\",
                            \"Tháng quá khứ → null.\",
                            \"Ví dụ nếu hiện tại là 04/2025:\",
                            [null, null, 140]
                        ],

                        \"trend_indicators\": [
                            \"Mỗi tháng có 1 đánh giá xu hướng.\",
                            \"Ví dụ:\",
                            [\"Điều chỉnh nhẹ\", \"Tăng trưởng ổn định\", \"Bùng nổ dự kiến\"]
                        ]
                    },

                    \"recommendations\": [
                        {
                            \"category\": \"Ngắn hạn/Trung hạn/Dài hạn\",
                            \"title\": \"Tiêu đề khuyến nghị\",
                            \"content\": \"Mô tả chi tiết và cách thực hiện\",
                            \"priority\": \"Cao/Trung bình/Thấp\",
                            \"expected_impact\": \"Tác động dự kiến\",
                            \"timeline\": \"Thời gian thực hiện\"
                        }
                    ],

                    \"risk_assessment\": \"Đánh giá rủi ro tổng thể và cách giảm thiểu\",

                    \"data_sources\": \"Nguồn dữ liệu và phương pháp phân tích\"
                }

                Lưu ý: Trả về đúng định dạng JSON, không có Markdown, không có dấu ** hoặc ký hiệu đặc biệt nào.
            "
        ];

        // ----- 3. Kiểm tra loại nghiên cứu -----
        $researchType = $attributes['research_type'] ?? null;
        if (!isset($prompts[$researchType])) {
            return ['success' => false, 'error' => 'Invalid research type'];
        }

        // ----- 4. Ghép dữ liệu crawl vào prompt -----
        $googleTrendsJson = json_encode($googleTrendsData, JSON_UNESCAPED_UNICODE);
        $redditJson = json_encode($redditData, JSON_UNESCAPED_UNICODE);
        $youtubeJson = json_encode($youtubeData, JSON_UNESCAPED_UNICODE);
        $newsJson = json_encode($newsData, JSON_UNESCAPED_UNICODE);

        $prompt = $prompts[$researchType] . "

        ===============================
        📊 DỮ LIỆU THỰC TẾ BỔ TRỢ
        Nguồn: Google Trends, Reddit, YouTube, News APIs

        🔹 Google Trends - Search Interest Over Time:
        $googleTrendsJson

        🔹 Reddit Discussions & Community Sentiment:
        $redditJson

        🔹 YouTube Videos & Trending Content:
        $youtubeJson

        🔹 News Articles & Media Coverage:
        $newsJson

        Lưu ý: 
        - Dữ liệu trên được thu thập tự động từ các nguồn công khai
        - Google Trends: Xu hướng tìm kiếm, mức độ quan tâm theo thời gian
        - Reddit: Thảo luận thực tế từ người dùng, sentiment analysis
        - YouTube: Video trends, view counts, engagement metrics
        - News: Tin tức mới nhất liên quan đến sản phẩm/ngành
        - Hãy dựa vào dữ liệu này để đưa ra phân tích chính xác và có căn cứ
        ===============================
        ";

        // Log prompt để debug
        Log::channel('single')->info('========== PROMPT GỬI ĐẾN GEMINI ==========');
        Log::channel('single')->info("Research Type: {$researchType}");
        Log::channel('single')->info("Product: {$product->name}");
        Log::channel('single')->info($prompt);
        Log::channel('single')->info('========== KẾT THÚC PROMPT ==========');

        // ----- 5. Gọi API Gemini -----
        set_time_limit(500);

        $result = $this->callGeminiApi($prompt);
        if (!$result['success']) {
            Log::error('Gemini API Error', $result['error']);
            return [
                'success' => false,
                'error' => $result['error']['message'] ?? 'Lỗi khi gọi API AI',
                'details' => $result['error']
            ];
        }

        $parsedData = $result['data'];

        // ----- 7. Lưu dữ liệu vào DB (nếu cần) -----
        /*
        $marketResearch = $this->marketAnalysisRepository->create([
            'user_id'       => auth()->id(),
            'product_id'    => $productId,
            'research_type' => $researchType,
            'start_date'    => $attributes['start_date'],
            'end_date'      => $attributes['end_date'],
            'status'        => 'completed',
            'analysis_data' => json_encode($parsedData, JSON_UNESCAPED_UNICODE),
        ]);
        */

        return [
            'success' => true,
            'type'    => $researchType,
            'data'    => $parsedData,
        ];
    }

    public function update($id, $attributes)
    {
        return $this->marketAnalysisRepository->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->marketAnalysisRepository->delete($id);
    }

    public function find($id)
    {
        return $this->marketAnalysisRepository->find($id);
    }

    public function get($conditions = [])
    {
        return $this->marketAnalysisRepository->get($conditions);
    }

    public function search($search)
    {
        $search = array_filter($search, fn ($value) => ! is_null($value) && $value !== '');

        return $this->marketAnalysisRepository->search($search);
    }

    public function exportReport($type, $analysisData, $product)
    {
        if ($type === 'pdf') {
            return $this->exportToPDF($analysisData, $product);
        } elseif ($type === 'word') {
            return $this->exportToWord($analysisData, $product);
        }

        throw new \InvalidArgumentException('Invalid export type. Only "pdf" and "word" are supported.');
    }

    private function exportToPDF($analysisData, $product)
    {
        $data = $analysisData['data'];

        $viewData = [
            'product' => $product,
            'data' => $data,
            'analysisType' => $analysisData['type'] ?? 'trend',
            'generatedAt' => now()->format('d/m/Y H:i'),
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('dashboard.market_analysis.exports.report', $viewData);

        // Cấu hình DomPDF để xử lý hình ảnh và fonts tốt hơn
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'DejaVu Sans',
            'dpi' => 150,
        ]);

        $filename = 'bao-cao-phan-tich-thi-truong-' . Str::slug($product->name) . '-' . now()->format('Y-m-d-H-i-s') . '.pdf';

        return $pdf->download($filename);
    }

    private function exportToWord($analysisData, $product)
    {
        $data = $analysisData['data'];

        // Tạo nội dung HTML cho Word document
        $htmlContent = $this->buildWordHtmlContent($data, $product, $analysisData);

        $filename = 'bao-cao-phan-tich-thi-truong-' . Str::slug($product->name) . '-' . now()->format('Y-m-d-H-i-s') . '.doc';

        // Tạo file HTML temp và trả về như .doc (Word có thể mở được)
        $tempFile = tempnam(sys_get_temp_dir(), 'html_word_export');
        file_put_contents($tempFile, $htmlContent);

        return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
    }

    private function buildWordHtmlContent($data, $product, $analysisData)
    {
        // Function to clean text
        $cleanText = function($text) {
            if (!$text) return '';

            // Remove HTML tags
            $text = strip_tags($text);

            // Convert HTML entities back to characters
            $text = html_entity_decode($text, ENT_QUOTES | ENT_XML1, 'UTF-8');

            // Remove dangerous characters
            $text = preg_replace('/[<>\"&]/', '', $text);

            // Ensure UTF-8
            if (!mb_check_encoding($text, 'UTF-8')) {
                $text = mb_convert_encoding($text, 'UTF-8', 'auto');
            }

            return $text;
        };

        $html = '<!DOCTYPE html>
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>BÁO CÁO PHÂN TÍCH THỊ TRƯỜNG</title>
    <style>
        @page {
            size: A4;
            margin: 1in;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
            line-height: 1.5;
        }
        h1 {
            font-size: 24pt;
            font-weight: bold;
            text-align: center;
            margin: 40pt 0;
            page-break-after: avoid;
        }
        h2 {
            font-size: 16pt;
            font-weight: bold;
            margin: 20pt 0 10pt 0;
            page-break-after: avoid;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5pt;
        }
        h3 {
            font-size: 14pt;
            font-weight: bold;
            margin: 15pt 0 8pt 0;
        }
        p {
            margin: 8pt 0;
        }
        .bold {
            font-weight: bold;
        }
        .section {
            margin: 20pt 0;
            page-break-inside: avoid;
        }
        .footer {
            text-align: center;
            font-size: 10pt;
            color: #666;
            font-style: italic;
            margin-top: 40pt;
        }
        .trend-item, .recommendation-item {
            margin: 8pt 0;
            padding: 8pt;
            border-left: 3pt solid #4f46e5;
        }
        .priority-high { border-left-color: #dc2626; }
        .priority-medium { border-left-color: #d97706; }
        .priority-low { border-left-color: #10b981; }
    </style>
</head>
<body>';

        // Title
        $html .= '<h1>BÁO CÁO PHÂN TÍCH THỊ TRƯỜNG</h1>';

        // Product Information
        $analysisTypes = [
            'trend' => 'Xu hướng thị trường',
            'consumer' => 'Khách hàng mục tiêu',
            'competitor' => 'Đối thủ cạnh tranh'
        ];

        $html .= '<h2>THÔNG TIN SẢN PHẨM</h2>';
        $html .= '<p><strong>Tên sản phẩm:</strong> ' . $cleanText($product->name) . '</p>';
        $html .= '<p><strong>Ngành nghề:</strong> ' . $cleanText($product->industry) . '</p>';
        $html .= '<p><strong>Mô tả:</strong> ' . $cleanText($product->description) . '</p>';
        $html .= '<p><strong>Loại phân tích:</strong> ' . ($analysisTypes[$analysisData['type']] ?? 'Phân tích thị trường') . '</p>';

        // Consumer Analysis Section
        if ($analysisData['type'] === 'consumer') {
            if (isset($data['age_range']) || isset($data['income']) || isset($data['interests'])) {
                $html .= '<div class="section">';
                $html .= '<h2>PHÂN TÍCH KHÁCH HÀNG MỤC TIÊU</h2>';

                if (isset($data['age_range'])) {
                    $html .= '<h3>Độ tuổi mục tiêu</h3>';
                    $html .= '<p>' . $cleanText($data['age_range']) . '</p>';
                }

                if (isset($data['income'])) {
                    $html .= '<h3>Mức thu nhập</h3>';
                    $html .= '<p>' . $cleanText($data['income']) . '</p>';
                }

                if (isset($data['interests']) && is_array($data['interests'])) {
                    $html .= '<h3>Sở thích</h3>';
                    $html .= '<ul>';
                    foreach ($data['interests'] as $interest) {
                        $html .= '<li>' . $cleanText($interest) . '</li>';
                    }
                    $html .= '</ul>';
                }

                if (isset($data['behaviors']) && is_array($data['behaviors'])) {
                    $html .= '<h3>Hành vi tiêu dùng</h3>';
                    $html .= '<ul>';
                    foreach ($data['behaviors'] as $behavior) {
                        $html .= '<li>' . $cleanText($behavior) . '</li>';
                    }
                    $html .= '</ul>';
                }

                if (isset($data['pain_points']) && is_array($data['pain_points'])) {
                    $html .= '<h3>Vấn đề khách hàng gặp phải</h3>';
                    $html .= '<ul>';
                    foreach ($data['pain_points'] as $pain) {
                        $html .= '<li>' . $cleanText($pain) . '</li>';
                    }
                    $html .= '</ul>';
                }

                $html .= '</div>';
            }
        }

        // Competitors Analysis Section
        if ($analysisData['type'] === 'competitor' && isset($data['competitors']) && is_array($data['competitors'])) {
            $html .= '<div class="section">';
            $html .= '<h2>ĐỐI THỦ CẠNH TRANH</h2>';

            foreach ($data['competitors'] as $index => $competitor) {
                $html .= '<div style="margin-bottom: 20px; border: 1px solid #ddd; padding: 15px; border-radius: 8px;">';
                $html .= '<h3>Đối thủ ' . ($index + 1) . ': ' . $cleanText($competitor['name'] ?? 'N/A') . '</h3>';

                if (isset($competitor['url'])) {
                    $html .= '<p><strong>Website:</strong> ' . $cleanText($competitor['url']) . '</p>';
                }

                if (isset($competitor['strengths']) && is_array($competitor['strengths'])) {
                    $html .= '<h4>Điểm mạnh:</h4>';
                    $html .= '<ul>';
                    foreach ($competitor['strengths'] as $strength) {
                        $html .= '<li>' . $cleanText($strength) . '</li>';
                    }
                    $html .= '</ul>';
                }

                if (isset($competitor['weaknesses']) && is_array($competitor['weaknesses'])) {
                    $html .= '<h4>Điểm yếu:</h4>';
                    $html .= '<ul>';
                    foreach ($competitor['weaknesses'] as $weakness) {
                        $html .= '<li>' . $cleanText($weakness) . '</li>';
                    }
                    $html .= '</ul>';
                }

                $html .= '</div>';
            }
            $html .= '</div>';
        }

        // Market Overview
        if (isset($data['market_size'])) {
            $html .= '<div class="section">';
            $html .= '<h2>TỔNG QUAN THỊ TRƯỜNG</h2>';
            $html .= '<p><strong>Quy mô thị trường:</strong> ' . $cleanText($data['market_size']) . '</p>';
            $html .= '<p><strong>Tốc độ tăng trưởng:</strong> ' . $cleanText($data['growth_rate']) . '</p>';
            $html .= '</div>';
        }

        // Analysis
        if (isset($data['analysis'])) {
            $html .= '<div class="section">';
            $html .= '<h2>PHÂN TÍCH THỊ TRƯỜNG HIỆN TẠI</h2>';
            $html .= '<p>' . str_replace("\n", '</p><p>', $cleanText($data['analysis'])) . '</p>';
            $html .= '</div>';
        }

        // Emerging Trends
        if (isset($data['emerging_trends']) && is_array($data['emerging_trends'])) {
            $html .= '<div class="section">';
            $html .= '<h2>XU HƯỚNG MỚI NỔI</h2>';
            foreach ($data['emerging_trends'] as $trend) {
                $html .= '<div class="trend-item">';
                $html .= '<h3>' . $cleanText($trend['trend']) . '</h3>';
                $html .= '<p><strong>Mức độ ảnh hưởng:</strong> ' . $cleanText($trend['impact_level']) . '</p>';
                $html .= '<p><strong>Mô tả:</strong> ' . $cleanText($trend['description']) . '</p>';
                $html .= '<p><strong>Thời gian:</strong> ' . $cleanText($trend['timeline']) . '</p>';
                $html .= '</div>';
            }
            $html .= '</div>';
        }

        // SWOT Analysis
        if (isset($data['swot_analysis'])) {
            $html .= '<div class="section">';
            $html .= '<h2>PHÂN TÍCH SWOT</h2>';

            if (isset($data['swot_analysis']['strengths'])) {
                $html .= '<h3>Điểm mạnh:</h3><ul>';
                foreach ($data['swot_analysis']['strengths'] as $strength) {
                    $html .= '<li>' . $cleanText($strength) . '</li>';
                }
                $html .= '</ul>';
            }

            if (isset($data['swot_analysis']['weaknesses'])) {
                $html .= '<h3>Điểm yếu:</h3><ul>';
                foreach ($data['swot_analysis']['weaknesses'] as $weakness) {
                    $html .= '<li>' . $cleanText($weakness) . '</li>';
                }
                $html .= '</ul>';
            }

            if (isset($data['swot_analysis']['opportunities'])) {
                $html .= '<h3>Cơ hội:</h3><ul>';
                foreach ($data['swot_analysis']['opportunities'] as $opportunity) {
                    $html .= '<li>' . $cleanText($opportunity) . '</li>';
                }
                $html .= '</ul>';
            }

            if (isset($data['swot_analysis']['threats'])) {
                $html .= '<h3>Thách thức:</h3><ul>';
                foreach ($data['swot_analysis']['threats'] as $threat) {
                    $html .= '<li>' . $cleanText($threat) . '</li>';
                }
                $html .= '</ul>';
            }
            $html .= '</div>';
        }

        // Forecast
        if (isset($data['forecast'])) {
            $html .= '<div class="section">';
            $html .= '<h2>DỰ BÁO XU HƯỚNG</h2>';
            $html .= '<p>' . str_replace("\n", '</p><p>', $cleanText($data['forecast'])) . '</p>';
            $html .= '</div>';
        }

        // Recommendations
        if (isset($data['recommendations'])) {
            $html .= '<div class="section">';
            $html .= '<h2>KHUYẾN NGHỊ CHIẾN LƯỢC</h2>';
            foreach ($data['recommendations'] as $recommendation) {
                $priorityClass = 'priority-' . strtolower($recommendation['priority'] ?? 'low');
                $html .= '<div class="recommendation-item ' . $priorityClass . '">';
                $html .= '<h3>' . $cleanText($recommendation['category']) . ' - ' . $cleanText($recommendation['title']) . '</h3>';
                $html .= '<p><strong>Mô tả:</strong> ' . $cleanText($recommendation['content']) . '</p>';
                $html .= '<p><strong>Độ ưu tiên:</strong> ' . $cleanText($recommendation['priority']) . '</p>';
                $html .= '<p><strong>Tác động dự kiến:</strong> ' . $cleanText($recommendation['expected_impact']) . '</p>';
                $html .= '<p><strong>Thời gian thực hiện:</strong> ' . $cleanText($recommendation['timeline']) . '</p>';
                $html .= '</div>';
            }
            $html .= '</div>';
        }

        // Risk Assessment
        if (isset($data['risk_assessment'])) {
            $html .= '<div class="section">';
            $html .= '<h2>ĐÁNH GIÁ RỦI RO</h2>';
            $html .= '<p>' . str_replace("\n", '</p><p>', $cleanText($data['risk_assessment'])) . '</p>';
            $html .= '</div>';
        }

        // Data Sources
        if (isset($data['data_sources'])) {
            $html .= '<div class="section">';
            $html .= '<h2>NGUỒN DỮ LIỆU</h2>';
            $html .= '<p>' . $cleanText($data['data_sources']) . '</p>';
            $html .= '</div>';
        }

        // Footer
        $html .= '<div class="footer">';
        $html .= '<p>Báo cáo được tạo tự động bởi AI Marketer Pro vào ngày ' . now()->format('d/m/Y H:i') . '</p>';
        $html .= '</div>';

        $html .= '</body></html>';

        return $html;
    }
}
