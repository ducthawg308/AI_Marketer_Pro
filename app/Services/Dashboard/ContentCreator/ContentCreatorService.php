<?php

namespace App\Services\Dashboard\ContentCreator;

use App\Services\AI\AIManager;
use App\Services\AI\PromptService;
use App\Models\Dashboard\ContentCreator\AiSetting;
use App\Models\Dashboard\AudienceConfig\Product;
use App\Models\Dashboard\ContentCreator\Ad;
use App\Models\Dashboard\ContentCreator\AdImage;
use App\Models\Dashboard\ContentCreator\Video;
use App\Repositories\Interfaces\Dashboard\ContentCreator\ContentCreatorInterface;
use App\Services\BaseService;
use App\Services\Dashboard\ContentCreator\VideoService;
use Cloudinary\Cloudinary;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ContentCreatorService extends BaseService
{

  public function __construct(
    private ContentCreatorInterface $contentCreatorRepository,
    private VideoService $videoService
  ) {
  }

  public function createManual(array $attributes)
  {
    $mediaType = $attributes['media_type'] ?? 'text';
    $ad = $this->contentCreatorRepository->create([
      'type' => 'manual',
      'media_type' => $mediaType,
      'ad_title' => $attributes['ad_title'],
      'ad_content' => $attributes['ad_content'],
      'hashtags' => $attributes['hashtags'] ?? null,
      'emojis' => $attributes['emojis'] ?? null,
    ]);

    if ($mediaType === 'image' && !empty($attributes['ad_images']) && is_array($attributes['ad_images'])) {
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

    // Handle Video logic
    if ($mediaType === 'video') {
      if (!empty($attributes['video_id'])) {
        // User selected an existing video
        Log::info("Linking video ID {$attributes['video_id']} to Ad ID {$ad->id}");
        $ad->update(['video_id' => $attributes['video_id']]);
      } elseif (!empty($attributes['ad_video']) && $attributes['ad_video'] instanceof \Illuminate\Http\UploadedFile) {
          // User uploaded a new video
          Log::info("Uploading new video for Ad ID {$ad->id}");
          $video = $this->videoService->uploadVideo($attributes['ad_video'], [
              'user_id' => Auth::id(),
          ]);
          $ad->update(['video_id' => $video->id]);
      }
    }
    
    return $ad->fresh();
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

    $promptService = app(PromptService::class);
    $aiClient = app(AIManager::class)->driver();

    $promptVars = [
        'name' => $nameProduct,
        'industry' => $industryProduct,
        'description' => $descriptionProduct,
        'age_range' => $targetCustomerAgeRange,
        'income_level' => $targetCustomerIncomeLevel,
        'interests' => $targetCustomerInterests,
        'competitors' => $competitorsList,
        'platform' => $platform,
        'language' => $language,
        'tone' => $tone,
        'length' => $length,
    ];

    $prompt = $promptService->getPrompt('content-creator-product', $promptVars);
    $result = $aiClient->generate($prompt, ['json' => true]);

    if (!$result['success']) {
      return response()->json($result['error'] ?? 'AI Error', 500);
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

    $promptService = app(PromptService::class);
    $aiClient = app(AIManager::class)->driver();

    $promptVars = [
        'link' => $link,
        'platform' => $platform,
        'language' => $language,
        'tone' => $tone,
        'length' => $length,
    ];

    $prompt = $promptService->getPrompt('content-creator-link', $promptVars);
    $result = $aiClient->generate($prompt, ['json' => true]);

    if (!$result['success']) {
      return response()->json($result['error'] ?? 'AI Error', 500);
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
    $mediaType = $attributes['media_type'] ?? 'text';
    $attributes['media_type'] = $mediaType;
    $ad = $this->contentCreatorRepository->update($id, $attributes);

    // Clean up media based on type change
    if ($mediaType === 'text') {
        $this->deleteAllImages($id);
        $ad->update(['video_id' => null]);
    } elseif ($mediaType === 'image') {
        $ad->update(['video_id' => null]);
    } elseif ($mediaType === 'video') {
        $this->deleteAllImages($id);
    }

    // Handle Image updates if type is image
    if ($mediaType === 'image') {
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
    }

    // Handle Video logic for update if type is video
    if ($mediaType === 'video') {
        if (isset($attributes['video_id'])) {
            $ad->update(['video_id' => !empty($attributes['video_id']) ? $attributes['video_id'] : null]);
        } elseif (!empty($attributes['ad_video']) && $attributes['ad_video'] instanceof \Illuminate\Http\UploadedFile) {
            // User uploaded a new video
            $video = $this->videoService->uploadVideo($attributes['ad_video'], [
                'user_id' => Auth::id(),
            ]);
            $ad->update(['video_id' => $video->id]);
        }
    }

    return $ad;
  }

  protected function deleteAllImages($ad_id)
  {
      $images = AdImage::where('ad_id', $ad_id)->get();
      foreach ($images as $image) {
          $this->deleteImageFromCloudinary($image->image_path);
          $image->delete();
      }
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
