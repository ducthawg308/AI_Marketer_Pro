<?php

namespace App\Services\Dashboard\MarketAnalysis;

use App\Models\Dashboard\AudienceConfig\Product;
use App\Repositories\Interfaces\Dashboard\MarketAnalysis\MarketAnalysisInterface;
use App\Services\BaseService;

class MarketAnalysisService extends BaseService
{
    public function __construct(private MarketAnalysisInterface $marketAnalysisRepository) {}

    public function create($attributes)
    {
        return $this->marketAnalysisRepository->create($attributes);
    }

    public function consumer_analysis($attributes){

    }

    public function analysis($attributes){
        $apiKey = config('services.gemini.api_key');
        if (!$apiKey) {
            return ['success' => false, 'error' => 'Missing API Key'];
        }

        $productId = $attributes['product_id'] ?? null;
        $product = Product::find($productId);
        if (!$product) {
            return ['success' => false, 'error' => 'Product not found'];
        }

        // ----- 1. Định nghĩa prompts cho từng loại nghiên cứu -----
        $prompts = [
            'competitor' => "
                Bạn là một chuyên gia phân tích cạnh tranh.
                Hãy phân tích *đối thủ cạnh tranh* dựa trên dữ liệu sau:

                🔹 Sản phẩm/Dịch vụ: {$product->name}  
                🔹 Ngành nghề: {$product->industry}  
                🔹 Đối thủ chính:
                - Tên: {$product->competitor_name}
                - Website: {$product->competitor_url}
                - Mô tả: {$product->competitor_description}

                🔹 Khoảng thời gian phân tích: 
                - Bắt đầu: {$attributes['start_date']}
                - Kết thúc: {$attributes['end_date']}

                Yêu cầu:
                - Liệt kê tối thiểu 3 đối thủ tiềm năng.
                - Đánh giá điểm mạnh và điểm yếu của từng đối thủ.
                - Đưa ra gợi ý chiến lược cạnh tranh.
                - Trả về dữ liệu đúng định dạng JSON:
                {
                    \"competitors\": [
                        {\"name\": \"Tên đối thủ\", \"url\": \"Website\", \"strengths\": [\"Điểm mạnh 1\", \"Điểm mạnh 2\"], \"weaknesses\": [\"Điểm yếu 1\", \"Điểm yếu 2\"]}
                    ],
                    \"strategy\": [
                        {\"title\": \"Chiến lược đề xuất\", \"content\": \"Mô tả chi tiết\"}
                    ]
                }
            ",

            'consumer' => "
                Bạn là chuyên gia phân tích hành vi khách hàng.
                Hãy phân tích nhóm khách hàng mục tiêu cho sản phẩm sau:

                🔹 Sản phẩm/Dịch vụ: {$product->name}  
                🔹 Ngành nghề: {$product->industry}  
                🔹 Khoảng thời gian phân tích: {$attributes['start_date']} → {$attributes['end_date']}

                Yêu cầu:
                - Xác định độ tuổi, thu nhập, sở thích tiêu biểu của khách hàng mục tiêu.
                - Liệt kê các hành vi tiêu dùng phổ biến.
                - Nêu những vấn đề (pain points) mà khách hàng thường gặp.
                - Đưa ra các gợi ý chiến lược marketing phù hợp.
                - Trả về dữ liệu đúng định dạng JSON:

                {
                    \"age_range\": \"Độ tuổi\",
                    \"income\": \"Mức thu nhập\",
                    \"interests\": \"Sở thích chính\",
                    \"behaviors\": [\"Hành vi 1\", \"Hành vi 2\"],
                    \"pain_points\": [\"Vấn đề 1\", \"Vấn đề 2\"],
                    \"recommendations\": [
                        {\"title\": \"Chiến lược marketing\", \"content\": \"Mô tả chi tiết\"}
                    ]
                }
            ",

            'trend' => "
                Bạn là chuyên gia phân tích thị trường với 15 năm kinh nghiệm trong việc dự báo xu hướng và phát hiện cơ hội mới nổi.

                📊 THÔNG TIN PHÂN TÍCH:
                🔹 Ngành nghề: {$product->industry}
                🔹 Sản phẩm/Dịch vụ: {$product->name}
                🔹 Thị trường mục tiêu: Việt Nam
                🔹 Khoảng thời gian phân tích: {$attributes['start_date']} → {$attributes['end_date']}

                🎯 YÊU CẦU PHÂN TÍCH CHUYÊN SÂU:

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
                - Điểm mạnh (Strengths) của ngành hiện tại
                - Điểm yếu (Weaknesses) cần khắc phục
                - Cơ hội (Opportunities) từ xu hướng mới
                - Thách thức (Threats) cần đối phó

                4. Dữ liệu biểu đồ xu hướng (12 điểm dữ liệu tháng):
                - Chỉ số tăng trưởng thị trường theo tháng
                - Mức độ quan tâm của người tiêu dùng
                - Số liệu thực tế và dự báo có căn cứ

                5. Khuyến nghị chiến lược (5-7 khuyến nghị cụ thể):
                - Chiến lược ngắn hạn (3-6 tháng)
                - Chiến lược trung hạn (6-12 tháng)
                - Đầu tư công nghệ và đổi mới
                - Chiến lược marketing và brand positioning
                - Phát triển sản phẩm/dịch vụ mới

                ⚠️ LưU Ý QUAN TRỌNG: 
                - Sử dụng số liệu cụ thể và có thể xác minh được
                - Đưa ra phân tích dựa trên dữ liệu thực tế của thị trường Việt Nam
                - Tránh các khuyến nghị chung chung, phải cụ thể và có tính khả thi
                - Xem xét tác động của các yếu tố kinh tế vĩ mô

                📋 ĐỊNH DẠNG RESPONSE (JSON):
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
                        \"labels\": [\"Tháng 1/2024\", \"Tháng 2/2024\", ..., \"Tháng 12/2024\"],
                        \"actual_data\": [100, 105, 110, 115, 120, 125],
                        \"forecast_data\": [null, null, null, null, null, null, 130, 135, 140, 145, 150, 155],
                        \"trend_indicators\": [\"Tăng trưởng ổn định\", \"Bùng nổ dự kiến\", \"Điều chỉnh\"]
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
            "
        ];

        // ----- 2. Kiểm tra loại nghiên cứu -----
        $researchType = $attributes['research_type'] ?? null;
        if (!isset($prompts[$researchType])) {
            return ['success' => false, 'error' => 'Invalid research type'];
        }

        $prompt = $prompts[$researchType];

        // ----- 3. Gọi API Gemini -----
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=$apiKey";
        $data = [
            "contents" => [
                ["parts" => [["text" => $prompt]]]
            ]
        ];

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
            CURLOPT_POSTFIELDS => json_encode($data),
        ]);

        set_time_limit(500);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($httpCode !== 200) {
            return [
                'success' => false,
                'error' => 'Lỗi khi gọi API AI',
                'http_code' => $httpCode,
                'response' => json_decode($response, true),
                'curl_error' => $curlError
            ];
        }

        // ----- 4. Xử lý dữ liệu trả về -----
        $result = json_decode($response, true);
        $responseText = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';

        $jsonStart = strpos($responseText, '{');
        $jsonEnd = strrpos($responseText, '}');
        if ($jsonStart === false || $jsonEnd === false) {
            return ['success' => false, "error" => "Phản hồi không hợp lệ từ AI"];
        }

        $jsonData = substr($responseText, $jsonStart, $jsonEnd - $jsonStart + 1);
        $parsedData = json_decode($jsonData, true);

        // ----- 5. Lưu dữ liệu vào DB (nếu cần) -----
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
            'data'    => $parsedData
        ];
    }

    public function trend_analysis($attributes){

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