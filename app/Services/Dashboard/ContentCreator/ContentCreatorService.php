<?php

namespace App\Services\Dashboard\ContentCreator;

use App\Traits\GeminiApiTrait;
use App\Models\Dashboard\ContentCreator\AiSetting;
use App\Models\Dashboard\AudienceConfig\Product;
use App\Models\Dashboard\ContentCreator\AdImage;
use App\Repositories\Interfaces\Dashboard\ContentCreator\ContentCreatorInterface;
use App\Services\BaseService;
use Cloudinary\Cloudinary;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ContentCreatorService extends BaseService
{
  use GeminiApiTrait;

  public function __construct(private ContentCreatorInterface $contentCreatorRepository)
  {
  }

  public function createManual(array $attributes)
  {
    $ad = $this->contentCreatorRepository->create([
      'type' => 'manual',
      'ad_title' => $attributes['ad_title'],
      'ad_content' => $attributes['ad_content'],
      'hashtags' => $attributes['hashtags'] ?? null,
      'emojis' => $attributes['emojis'] ?? null,
    ]);

    if (!empty($attributes['ad_images']) && is_array($attributes['ad_images'])) {
      foreach ($attributes['ad_images'] as $image) {
        if ($image instanceof \Illuminate\Http\UploadedFile) {
          $cloudinaryPath = $this->uploadImageToCloudinary($image);

          AdImage::create([
            'ad_id' => $ad->id,
            'image_path' => $cloudinaryPath,
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
    
    $competitorsList = "";
    if (!empty($product->competitors) && is_array($product->competitors)) {
      foreach ($product->competitors as $c) {
        $competitorsList .= "- Tên: " . ($c['name'] ?? 'N/A') . " | Website: " . ($c['url'] ?? 'N/A') . "\n";
      }
    } else {
      $competitorsList = "- Chưa có thông tin đối thủ cụ thể.";
    }

    $prompt = "
        Bạn là chuyên gia Marketing & Copywriting với 10+ năm kinh nghiệm tại các agency hàng đầu.

        NHIỆM VỤ: Tạo bài đăng content marketing chuyên nghiệp, hấp dẫn và có tính thuyết phục cao.

        📊 THÔNG TIN SẢN PHẨM/DỊCH VỤ:
        - Tên: $nameProduct
        - Ngành: $industryProduct
        - Mô tả chi tiết: $descriptionProduct

        🎯 PHÂN TÍCH KHÁCH HÀNG MỤC TIÊU:
        - Độ tuổi: $targetCustomerAgeRange
        - Mức thu nhập: $targetCustomerIncomeLevel
        - Sở thích & hành vi: $targetCustomerInterests

        🔍 BỐI CẢNH THỊ TRƯỜNG:
        - Danh sách đối thủ: 
        $competitorsList
        → Hãy tìm góc độ khác biệt, tạo lợi thế cạnh tranh mà KHÔNG nhắc trực tiếp tên đối thủ

        ⚙️ YÊU CẦU KỸ THUẬT:
        - Platform: $platform
        - Ngôn ngữ: $language
        - Tone of voice: $tone
        - Độ dài: $length

        📝 HƯỚNG DẪN VIẾT:

        1. TIÊU ĐỀ (ad_title):
        - Hook mạnh mẽ, gây tò mò hoặc chạm pain point
        - Dài 40-60 ký tự cho $platform
        - Chứa từ khóa liên quan đến $industryProduct

        2. NỘI DUNG (ad_content):
        - MỞ ĐẦU: Đặt câu hỏi/thống kê/câu chuyện liên quan đến pain point của nhóm khách hàng $targetCustomerAgeRange, thu nhập $targetCustomerIncomeLevel
        - THÂN BÀI: 
            * Làm nổi bật 2-3 lợi ích cốt lõi từ $descriptionProduct
            * Kết nối với sở thích $targetCustomerInterests
            * Sử dụng social proof/số liệu nếu phù hợp
        - KẾT THÚC: CTA rõ ràng, tạo cảm giác khan hiếm/cấp bách

        3. HASHTAGS:
        - 5-8 hashtags phù hợp với $platform
        - Mix giữa: hashtag ngành ($industryProduct), trending, branded
        - Phân tích bối cảnh thị trường để tìm từ khóa ngách

        4. EMOJIS:
        - 3-5 emoji phù hợp tone $tone
        - Đặt ở vị trí chiến lược để tăng engagement

        🎨 NGUYÊN TẮC SÁNG TẠO:
        ✓ Viết theo phong cách storytelling nếu tone cho phép
        ✓ Tối ưu cho thuật toán $platform (engagement rate, dwell time)
        ✓ Cá nhân hóa theo insight khách hàng ($targetCustomerInterests)
        ✓ Tạo khác biệt với cách tiếp cận của đối thủ
        ✗ KHÔNG so sánh trực tiếp, hạ thấp đối thủ
        ✗ KHÔNG dùng ngôn ngữ chung chung, mờ nhạt

        {
            \"ad_title\": \"Tiêu đề hook mạnh mẽ\",
            \"ad_content\": \"Nội dung đầy đủ với cấu trúc rõ ràng, xuống dòng hợp lý\",
            \"hashtags\": \"#hashtag1 #hashtag2 #hashtag3\",
            \"emojis\": \"🎯💡✨\"
        }

        Lưu ý: Trả về đúng định dạng JSON, không có Markdown, không có dấu ** hoặc ký hiệu đặc biệt nào.
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
      'type' => 'product',
      'product_id' => $productId,
      'ad_title' => (isset($attributes['ad_title']) && $attributes['ad_title'] !== '') ? $attributes['ad_title'] : $parsedData['ad_title'],
      'ad_content' => $parsedData['ad_content'],
      'hashtags' => $parsedData['hashtags'] ?? null,
      'emojis' => $parsedData['emojis'] ?? null,
    ]);

    // Store AI-generated data in session to return as JSON if called via API
    if (isset($attributes['return_json']) && $attributes['return_json']) {
      return response()->json(['success' => true, 'ad_id' => $ad->id, 'data' => $parsedData]);
    }

    return $ad;
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
    $tone = $setting->tone;
    $length = $setting->length;

    $prompt = "
        Bạn là chuyên gia Content Repurposing & Social Media Marketing hàng đầu.

        NHIỆM VỤ: Phân tích nội dung từ URL và chuyển hóa thành bài đăng mạng xã hội viral, giữ nguyên giá trị thông tin nhưng tối ưu engagement.

        🔗 NGUỒN THAM KHẢO: $link

        Bước 1: HÃY TRUY CẬP VÀ PHÂN TÍCH LINK
        - Đọc kỹ toàn bộ nội dung
        - Xác định: key message, insight chính, góc nhìn độc đáo
        - Trích xuất: số liệu, quotes, case study (nếu có)

        Bước 2: TÁI CẤU TRÚC CHO $platform

        ⚙️ THÔNG SỐ KỸ THUẬT:
        - Platform: $platform
        - Ngôn ngữ: $language  
        - Tone of voice: $tone
        - Độ dài: $length

        📝 YÊU CẦU NỘI DUNG:

        1. TIÊU ĐỀ (ad_title):
        - Đúc kết key message của link thành hook thu hút
        - Phù hợp định dạng $platform và tone $tone
        - Dài 40-60 ký tự, chứa từ khóa chính

        2. NỘI DUNG (ad_content):
        - MỞ ĐẦU: 
            * Pattern interrupt - làm người đọc dừng scroll
            * Có thể dùng câu hỏi/thống kê/micro-story từ link
        
        - THÂN BÀI:
            * Tổng hợp 2-3 điểm giá trị nhất từ link
            * Viết lại bằng ngôn ngữ $language, tone $tone
            * Thêm insight/góc nhìn cá nhân nếu phù hợp
            * Format dễ đọc trên mobile (đoạn ngắn, bullet points nếu cần)
        
        - KẾT THÚC:
            * CTA phù hợp với mục đích bài viết
            * Khuyến khích tương tác (comment, share, click link)

        3. HASHTAGS:
        - 5-8 hashtags dựa trên chủ đề link
        - Mix: niche hashtags (low competition) + popular hashtags
        - Research trending hashtags liên quan trên $platform

        4. EMOJIS:
        - 3-6 emoji phù hợp với tone $tone và nội dung
        - Sử dụng để phân tách đoạn, tạo visual break

        🎯 NGUYÊN TẮC CHUYỂN HÓA:
        ✓ GIỮ: Thông tin chính xác, giá trị cốt lõi, insight từ link
        ✓ THAY ĐỔI: Cấu trúc, góc kể chuyện, examples, diễn đạt 100%
        ✓ TỐI ƯU: Cho thuật toán $platform (keywords, engagement hooks)
        ✓ CÁ NHÂN HÓA: Theo tone $tone và đặc thủ $platform
        ✗ KHÔNG copy-paste câu văn nguyên gốc
        ✗ KHÔNG làm mất đi độ chính xác thông tin
        ✗ KHÔNG viết quá dài dòng, lan man

        💡 LƯU Ý ĐẶC BIỆT:
        - Nếu link chứa data/nghiên cứu: Cite nguồn một cách tinh tế
        - Nếu link là tin tức: Thêm góc nhìn/takeaway cho audience
        - Nếu link là tutorial: Summarize thành actionable tips
        - Độ dài $length phải phù hợp với chuẩn best practice của $platform

        {
            \"ad_title\": \"Tiêu đề tái cấu trúc từ key message của link\",
            \"ad_content\": \"Nội dung hoàn chỉnh với cấu trúc rõ ràng, xuống dòng hợp lý\",
            \"hashtags\": \"#hashtag1 #hashtag2 #hashtag3\",
            \"emojis\": \"💡🔥🚀\"
        }

        Lưu ý: Trả về đúng định dạng JSON, không có Markdown, không có dấu ** hoặc ký hiệu đặc biệt nào.
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
      'type' => 'link',
      'link' => $link,
      'ad_title' => (isset($attributes['ad_title']) && $attributes['ad_title'] !== '') ? $attributes['ad_title'] : $parsedData['ad_title'],
      'ad_content' => $parsedData['ad_content'],
      'hashtags' => $parsedData['hashtags'] ?? null,
      'emojis' => $parsedData['emojis'] ?? null,
    ]);

    // Store AI-generated data in session to return as JSON if called via API
    if (isset($attributes['return_json']) && $attributes['return_json']) {
      return response()->json(['success' => true, 'ad_id' => $ad->id, 'data' => $parsedData]);
    }

    return $ad;
  }

  public function update($id, $attributes)
  {
    $ad = $this->contentCreatorRepository->update($id, $attributes);

    if (!empty($attributes['delete_images']) && is_array($attributes['delete_images'])) {
      $imagesToDelete = AdImage::whereIn('id', $attributes['delete_images'])
        ->where('ad_id', $id)
        ->get();

      foreach ($imagesToDelete as $image) {
        $this->deleteImageFromCloudinary($image->image_path);
        $image->delete();
      }
    }

    if (!empty($attributes['images']) && is_array($attributes['images'])) {
      foreach ($attributes['images'] as $image) {
        if ($image instanceof \Illuminate\Http\UploadedFile) {
          $cloudinaryPath = $this->uploadImageToCloudinary($image);

          AdImage::create([
            'ad_id' => $id,
            'image_path' => $cloudinaryPath,
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
      $this->deleteImageFromCloudinary($image->image_path);
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
    $search = array_filter($search, fn($value) => !is_null($value) && $value !== '');

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

  /**
   * Upload image to Cloudinary
   */
  private function uploadImageToCloudinary(\Illuminate\Http\UploadedFile $file): ?string
  {
    try {
      // Create temporary file path
      $tempPath = sys_get_temp_dir() . '/' . uniqid() . '_' . $file->getClientOriginalName();
      file_put_contents($tempPath, $file->get());

      // Initialize Cloudinary
      $cloudinary = new Cloudinary();

      // Upload image to Cloudinary
      $cloudinaryResponse = $cloudinary->uploadApi()->upload($tempPath, [
        'folder' => 'content_images',
        'resource_type' => 'image',
        'public_id' => time() . '_' . Str::slug(basename($file->getClientOriginalName(), '.' . $file->getClientOriginalExtension())),
        'format' => $file->getClientOriginalExtension(),
        'timeout' => 60, // 60 seconds timeout for images
      ]);

      // Clean up temp file after successful upload
      @unlink($tempPath);

      return $cloudinaryResponse['public_id'];

    } catch (\Exception $e) {
      // Clean up temp file on error
      @unlink($tempPath);
      Log::error('Error uploading image to Cloudinary: ' . $e->getMessage());
      return null;
    }
  }

  /**
   * Delete image from Cloudinary
   */
  private function deleteImageFromCloudinary(string $publicId): bool
  {
    try {
      if (!$publicId) {
        return false;
      }

      // Initialize Cloudinary
      $cloudinary = new Cloudinary();

      // Delete image from Cloudinary
      $cloudinary->uploadApi()->destroy($publicId, [
        'resource_type' => 'image',
        'invalidate' => true,
      ]);

      return true;

    } catch (\Exception $e) {
      Log::error('Error deleting image from Cloudinary: ' . $e->getMessage());
      return false;
    }
  }
}
