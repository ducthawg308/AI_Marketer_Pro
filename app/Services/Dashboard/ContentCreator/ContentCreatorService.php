<?php

namespace App\Services\Dashboard\ContentCreator;

use App\Traits\GeminiApiTrait;

use App\Models\Dashboard\ContentCreator\AiSetting;
use App\Models\Dashboard\AudienceConfig\Product;
use App\Models\Dashboard\ContentCreator\AdImage;
use App\Repositories\Interfaces\Dashboard\ContentCreator\ContentCreatorInterface;
use App\Services\BaseService;

class ContentCreatorService extends BaseService
{
    use GeminiApiTrait;

    public function __construct(private ContentCreatorInterface $contentCreatorRepository) {}

    public function createManual(array $attributes)
    {
        $ad = $this->contentCreatorRepository->create([
            'type'       => 'manual',
            'ad_title'   => $attributes['ad_title'],
            'ad_content' => $attributes['ad_content'],
            'hashtags'   => $attributes['hashtags'] ?? null,
            'emojis'     => $attributes['emojis'] ?? null,
        ]);

        if (!empty($attributes['ad_images']) && is_array($attributes['ad_images'])) {
            foreach ($attributes['ad_images'] as $image) {
                if ($image instanceof \Illuminate\Http\UploadedFile) {
                    $path = $image->store('ads', 'public');

                    AdImage::create([
                        'ad_id'      => $ad->id,
                        'image_path' => $path,
                        'facebook_media_id' => null,
                    ]);
                }
            }
        }

        return $ad;
    }

    public function createFromProduct($attributes)
    {
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

        $result = $this->callGeminiApi($prompt);
        if (!$result['success']) {
            return response()->json($result['error'], 500);
        }

        $parsedData = $result['data'];

        if (!isset($parsedData['ad_title']) || !isset($parsedData['ad_content'])) {
            return response()->json(["error" => "Thiếu ad_title hoặc ad_content"], 500);
        }

        $ad = $this->contentCreatorRepository->create([
            'type'       => 'product',
            'product_id' => $productId,
            'ad_title'   => (isset($attributes['ad_title']) && $attributes['ad_title'] !== '') ? $attributes['ad_title'] : $parsedData['ad_title'],
            'ad_content' => $parsedData['ad_content'],
            'hashtags'   => $parsedData['hashtags'] ?? null,
            'emojis'     => $parsedData['emojis'] ?? null,
        ]);

        return response()->json(['success' => true, 'ad_id' => $ad->id, 'data' => $parsedData]);
    }

    public function createFromLink(array $attributes)
    {
        $link = $attributes['link'] ?? null;
        if (!$link) {
            return response()->json(['error' => 'Missing link'], 422);
        }

        $settingId = $attributes['ai_setting_id'] ?? null;
        $setting = AiSetting::find($settingId);
        if (!$setting) {
            return response()->json(['error' => 'AI setting not found'], 404);
        }

        $platform = $setting->platform;
        $language = $setting->language;
        $tone     = $setting->tone;
        $length   = $setting->length;

        $prompt = "
        Bạn là một chuyên gia viết content mạng xã hội chuyên nghiệp.

        Hãy đọc và phân tích nội dung từ link sau: $link

        Sau đó, hãy viết lại thành một bài đăng mạng xã hội với các yêu cầu:

        🔹 Nền tảng: $platform  
        🔹 Ngôn ngữ: $language  
        🔹 Giọng điệu: $tone  
        🔹 Độ dài: $length  

        Yêu cầu:
        - Viết bài đăng gồm tiêu đề, nội dung chính, emoji và hashtag.
        - Có mở đầu thu hút, nội dung súc tích, kết thúc bằng lời kêu gọi hành động.
        - Không copy y nguyên, phải diễn đạt lại.
        - Phù hợp với nền tảng và giọng điệu đã chọn.

        Trả về đúng định dạng JSON sau (chỉ JSON, không thêm chú thích):

        ```json
        {
            \"ad_title\": \"Tiêu đề bài viết\",
            \"ad_content\": \"Nội dung bài đăng mạng xã hội\",
            \"hashtags\": \"#abc #xyz #sample\",
            \"emojis\": \"🔥✨🚀\"
        }
        ```
        ";

        $result = $this->callGeminiApi($prompt);
        if (!$result['success']) {
            return response()->json($result['error'], 500);
        }

        $parsedData = $result['data'];

        if (!isset($parsedData['ad_title']) || !isset($parsedData['ad_content'])) {
            return response()->json(["error" => "Thiếu ad_title hoặc ad_content"], 500);
        }

        $ad = $this->contentCreatorRepository->create([
            'type'       => 'link',
            'link'       => $link,
            'ad_title'   => (isset($attributes['ad_title']) && $attributes['ad_title'] !== '') ? $attributes['ad_title'] : $parsedData['ad_title'],
            'ad_content' => $parsedData['ad_content'],
            'hashtags'   => $parsedData['hashtags'] ?? null,
            'emojis'     => $parsedData['emojis'] ?? null,
        ]);

        return response()->json(['success' => true, 'ad_id' => $ad->id, 'data' => $parsedData]);
    }

    public function update($id, $attributes)
    {
        $ad = $this->contentCreatorRepository->update($id, $attributes);

        if (!empty($attributes['delete_images']) && is_array($attributes['delete_images'])) {
            $imagesToDelete = AdImage::whereIn('id', $attributes['delete_images'])
                                    ->where('ad_id', $id)
                                    ->get();

            foreach ($imagesToDelete as $image) {
                if ($image->image_path && \Storage::disk('public')->exists($image->image_path)) {
                    \Storage::disk('public')->delete($image->image_path);
                }
                
                $image->delete();
            }
        }

        if (!empty($attributes['images']) && is_array($attributes['images'])) {
            foreach ($attributes['images'] as $image) {
                if ($image instanceof \Illuminate\Http\UploadedFile) {
                    $path = $image->store('ads', 'public');

                    AdImage::create([
                        'ad_id'      => $id,
                        'image_path' => $path,
                        'facebook_media_id' => null,
                    ]);
                }
            }
        }

        return $ad;
    }

    public function delete($id)
    {
        $ad = $this->contentCreatorRepository->find($id);

        if (!$ad) {
            return false;
        }

        $images = AdImage::where('ad_id', $id)->get();

        foreach ($images as $image) {
            if ($image->image_path && \Storage::disk('public')->exists($image->image_path)) {
                \Storage::disk('public')->delete($image->image_path);
            }

            $image->delete();
        }

        return $this->contentCreatorRepository->delete($id);
    }

    public function find($id)
    {
        return $this->contentCreatorRepository->find($id);
    }

    public function get($conditions = [])
    {
        return $this->contentCreatorRepository->get($conditions);
    }

    public function search($search)
    {
        $search = array_filter($search, fn ($value) => !is_null($value) && $value !== '');

        return $this->contentCreatorRepository->search($search);
    }

    public function updateSetting(int $userId, array $data)
    {
        return $this->contentCreatorRepository->updateSettingByUserId($userId, $data);
    }

    public function getSetting(int $userId)
    {
        return $this->contentCreatorRepository->getSettingByUserId($userId);
    }
}
