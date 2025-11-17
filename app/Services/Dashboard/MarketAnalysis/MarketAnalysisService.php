<?php

namespace App\Services\Dashboard\MarketAnalysis;

use App\Traits\GeminiApiTrait;

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

        // Lưu prompt ra file
        $promptFile = storage_path('logs/prompts/prompt_' . $researchType . '_' . date('Y-m-d_H-i-s') . '.txt');
        @mkdir(dirname($promptFile), 0755, true);
        file_put_contents($promptFile, $prompt);
        Log::info("Prompt đã lưu tại: {$promptFile}");

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
            'debug' => [
                'prompt_file' => $promptFile,
                'data_sources' => [
                    'reddit' => isset($redditData['success']) ? 'OK' : 'ERROR',
                    'youtube' => isset($youtubeData['success']) ? 'OK' : 'ERROR',
                    'news' => isset($newsData['success']) ? 'OK' : 'ERROR',
                ],
                'crawled_data' => [
                    'reddit_posts' => $redditData['summary']['total_posts'] ?? 0,
                    'youtube_videos' => $youtubeData['summary']['total_videos'] ?? 0,
                    'news_articles' => $newsData['total_results'] ?? 0,
                ]
            ]
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
}
