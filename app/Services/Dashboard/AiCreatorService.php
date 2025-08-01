<?php

namespace App\Services\Dashboard;

use App\Models\Dashboard\AiCreator\Ad;
use App\Models\Dashboard\AiCreator\AiSetting;
use App\Models\Dashboard\AudienceConfig\Product;
use App\Repositories\Interfaces\Dashboard\AiCreatorInterface;
use App\Services\BaseService;

class AiCreatorService extends BaseService
{
    public function __construct(private AiCreatorInterface $aiCreatorRepository) {}

    public function create($attributes)
    {
        $apiKey = config('services.gemini.api_key');
        if (!$apiKey) {
            return response()->json(['error' => 'Missing API Key'], 500);
        }

        $productId = $attributes['product_id'] ?? null;
        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $settingId = $attributes['ai_setting_id'] ?? null;
        $setting = AiSetting::find($settingId);
        if (!$setting) {
            return response()->json(['error' => 'AI setting not found'], 404);
        }

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$apiKey";
        $platform = $setting->platform;
        $language = $setting->language;
        $tone = $setting->tone;
        $length = $setting->length;
        $nameProduct = $product->name;
        $industryProduct = $product->industry;
        $descriptionProduct = $product->description;
        $targetCustomerAgeRange = $product->target_customer_age_range;
        $targetCustomerIncomeLevel = $product->target_customer_income_level;
        $targetCustomerInterests = $product->target_customer_interests;
        $competitorName = $product->competitor_name;
        $competitorUrl = $product->competitor_url;
        $competitorDescription = $product->competitor_description;

        $prompt = "
        Bạn là một chuyên gia viết content mạng xã hội chuyên nghiệp.

        Hãy tạo một bài đăng hoàn chỉnh cho mạng xã hội, dựa trên các thông tin sau:

        🔹 Nền tảng: $platform  
        🔹 Ngôn ngữ: $language  
        🔹 Giọng điệu: $tone  
        🔹 Độ dài: $length  
        🔹 Tên sản phẩm/dịch vụ: $nameProduct  
        🔹 Ngành nghề: $industryProduct  
        🔹 Mô tả sản phẩm: $descriptionProduct  
        🔹 Khách hàng mục tiêu:
        - Độ tuổi: $targetCustomerAgeRange
        - Thu nhập: $targetCustomerIncomeLevel
        - Sở thích: $targetCustomerInterests

        🔹 Đối thủ cạnh tranh:
        - Tên: $competitorName
        - Website: $competitorUrl
        - Mô tả: $competitorDescription

        Yêu cầu:
        - Viết bài đăng đầy đủ gồm tiêu đề, nội dung chính, emoji và hashtag.
        - Có mở đầu thu hút, nội dung súc tích, kết thúc bằng lời kêu gọi hành động.
        - Không đề cập hay so sánh trực tiếp với đối thủ.
        - Nhấn mạnh lợi ích và điểm nổi bật của sản phẩm/dịch vụ.
        - Phù hợp với nền tảng đã chọn và đúng giọng điệu.

        Trả về đúng định dạng JSON sau (chỉ JSON, không thêm chú thích hay giải thích):

        ```json
        {
        \"ad_title\": \"Tiêu đề bài viết\",
        \"ad_content\": \"Nội dung bài đăng mạng xã hội\",
        \"hashtags\": \"#abc #xyz #sample\",
        \"emojis\": \"🔥✨🚀\"
        }
        ```
        ";

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

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($httpCode !== 200) {
            return response()->json([
                'error' => 'Lỗi khi gọi API AI',
                'http_code' => $httpCode,
                'response' => json_decode($response, true),
                'curl_error' => $curlError
            ], 500);
        }

        $result = json_decode($response, true);
        $responseText = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';

        $jsonStart = strpos($responseText, '{');
        $jsonEnd = strrpos($responseText, '}');
        if ($jsonStart === false || $jsonEnd === false) {
            return response()->json(["error" => "Phản hồi không hợp lệ từ AI"], 500);
        }

        $jsonData = substr($responseText, $jsonStart, $jsonEnd - $jsonStart + 1);
        $parsedData = json_decode($jsonData, true);

        if (!isset($parsedData['ad_title']) || !isset($parsedData['ad_content'])) {
            return response()->json(["error" => "Thiếu ad_title hoặc ad_content"], 500);
        }

        $ad = $this->aiCreatorRepository->create([
            'product_id' => $productId,
            'ad_title' => $parsedData['ad_title'],
            'ad_content' => $parsedData['ad_content'],
            'hashtags' => $parsedData['hashtags'] ?? null,
            'emojis' => $parsedData['emojis'] ?? null,
        ]);

        return response()->json(['success' => true, 'ad_id' => $ad->id, 'data' => $parsedData]);
    }

    public function update($id, $attributes)
    {
        return $this->aiCreatorRepository->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->aiCreatorRepository->delete($id);
    }

    public function find($id)
    {
        return $this->aiCreatorRepository->find($id);
    }

    public function get($conditions = [])
    {
        return $this->aiCreatorRepository->get($conditions);
    }

    public function search($search)
    {
        $search = array_filter($search, fn ($value) => !is_null($value) && $value !== '');

        return $this->aiCreatorRepository->search($search);
    }

    public function updateSetting(int $userId, array $data)
    {
        return $this->aiCreatorRepository->updateSettingByUserId($userId, $data);
    }

    public function getSetting(int $userId)
    {
        return $this->aiCreatorRepository->getSettingByUserId($userId);
    }
}