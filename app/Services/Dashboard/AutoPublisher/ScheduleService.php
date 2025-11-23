<?php

namespace App\Services\Dashboard\AutoPublisher;

use App\Repositories\Interfaces\Dashboard\AutoPublisher\ScheduleInterface;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ScheduleService extends BaseService
{
    public function __construct(private ScheduleInterface $scheduleRepository) {}

    public function create($attributes)
    {
        return $this->scheduleRepository->create($attributes);
    }

    public function update($id, $attributes)
    {
        return $this->scheduleRepository->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->scheduleRepository->delete($id);
    }

    public function find($id)
    {
        return $this->scheduleRepository->find($id);
    }

    public function get($conditions = [])
    {
        return $this->scheduleRepository->get($conditions);
    }

    public function search($search)
    {
        $search = array_filter($search, fn ($value) => ! is_null($value) && $value !== '');

        return $this->scheduleRepository->search($search);
    }

    /**
     * Đăng bài lên Facebook Page theo lịch trình
     * 
     * @param int $scheduleId ID của lịch trình cần đăng
     * @return bool true nếu đăng thành công, false nếu thất bại
     */
    public function postToPage($scheduleId): bool
    {
        try {
            // 1. Lấy dữ liệu schedule kèm relations cần thiết
            $schedule = $this->scheduleRepository->findWithRelations($scheduleId, [
                'ad.adImages', // Thông tin quảng cáo và hình ảnh
                'userPage'     // Thông tin Facebook Page
            ]);
            
            // 2. Kiểm tra dữ liệu có đầy đủ không
            if (!$schedule || !$schedule->ad || !$schedule->userPage) {
                Log::error("Không tìm thấy dữ liệu cho lịch trình: {$scheduleId}");
                $this->scheduleRepository->update($scheduleId, ['status' => 'failed']);
                return false;
            }

            $ad = $schedule->ad;
            $userPage = $schedule->userPage;

            // 3. Kiểm tra access token có tồn tại không
            if (empty($userPage->page_access_token)) {
                Log::error("Access token của page này trống: {$userPage->page_id}");
                $this->scheduleRepository->update($scheduleId, ['status' => 'failed']);
                return false;
            }

            // 4. Tạo nội dung message từ thông tin quảng cáo
            $message = collect([
                $ad->ad_title,   // Tiêu đề quảng cáo
                $ad->ad_content, // Nội dung quảng cáo
                $ad->hashtags    // Hashtags
            ])
            ->filter()           // Loại bỏ các giá trị null/empty
            ->implode("\n\n");   // Nối với 2 dòng trống

            // 5. Chọn phương thức đăng bài dựa trên có ảnh hay không
            if ($ad->adImages->count() > 0) {
                // Đăng bài có kèm hình ảnh
                $result = $this->postWithImages($ad, $userPage, $message, $schedule);
            } else {
                // Đăng bài chỉ có text
                $result = $this->postTextOnly($userPage, $message, $schedule);
            }

            // 6. Cập nhật trạng thái schedule dựa trên kết quả
            $this->scheduleRepository->update($scheduleId, [
                'status' => $result['success'] ? 'posted' : 'failed',
                'facebook_post_id' => $result['facebook_post_id'] ?? null,
            ]);

            // 7. Cập nhật trạng thái quảng cáo nếu đăng thành công
            if ($result['success']) {
                try {
                    $ad->update(['status' => 'approved']);
                } catch (\Exception $e) {
                    // Log warning nhưng không làm fail toàn bộ process
                    // vì bài đã đăng thành công lên Facebook
                    Log::warning("Không thể cập nhật status cho ad {$ad->id}: " . $e->getMessage());
                }
            }

            return $result['success'];
            
        } catch (\Exception $e) {
            // 8. Xử lý exception và cập nhật trạng thái thất bại
            Log::error("Exception in postToPage for schedule {$scheduleId}: " . $e->getMessage());
            $this->scheduleRepository->update($scheduleId, ['status' => 'failed']);
            return false;
        }
    }

    /**
     * Đăng bài chỉ có text lên Facebook Page
     * 
     * @param object $userPage Thông tin Facebook Page
     * @param string $message Nội dung bài đăng
     * @param object $schedule Thông tin lịch trình
     * @return array ['success' => bool, 'facebook_post_id' => string|null]
     */
    protected function postTextOnly($userPage, $message, $schedule): array
    {
        // 1. Chuyển đổi thời gian scheduled sang UTC
        $publishTimeUtc = Carbon::parse($schedule->scheduled_time)->timezone('UTC');

        // 2. Chuẩn bị parameters cơ bản cho Facebook API
        $params = [
            'message' => $message,
            'access_token' => $userPage->page_access_token,
        ];

        // 3. Kiểm tra logic thời gian để quyết định đăng ngay hay schedule
        $minutesUntilPublish = Carbon::now('UTC')->diffInMinutes($publishTimeUtc, false);
        
        // Nếu thời gian đăng >= 10 phút nữa và là thời gian tương lai
        if ($minutesUntilPublish >= 10 && $publishTimeUtc->isFuture()) {
            // Schedule bài đăng cho tương lai
            $params['published'] = 'false';
            $params['scheduled_publish_time'] = $publishTimeUtc->timestamp;
        } else {
            // Đăng ngay lập tức
            $params['published'] = 'true';
        }

        // 4. Tạo URL endpoint cho Facebook Graph API
        $url = "https://graph.facebook.com/v23.0/{$userPage->page_id}/feed";

        // 5. Gửi request tới Facebook API
        $response = Http::asForm()->post($url, $params);

        // 6. Log lỗi nếu có
        if (!$response->successful()) {
            Log::error("Facebook API Error: " . $response->body());
        }

        // 7. Trả về kết quả
        return $response->successful()
            ? ['success' => true, 'facebook_post_id' => $response->json()['id'] ?? null]
            : ['success' => false];
    }

    /**
     * Đăng bài có kèm hình ảnh lên Facebook Page
     *
     * @param object $ad Thông tin quảng cáo
     * @param object $userPage Thông tin Facebook Page
     * @param string $message Nội dung bài đăng
     * @param object $schedule Thông tin lịch trình
     * @return array ['success' => bool, 'facebook_post_id' => string|null]
     */
    protected function postWithImages($ad, $userPage, $message, $schedule): array
    {
        $accessToken = $userPage->page_access_token;
        $pageId = $userPage->page_id;
        $mediaFbIds = []; // Mảng chứa Facebook Media IDs

        // BƯỚC 1: Upload từng ảnh lên Facebook và lấy Media ID
        foreach ($ad->adImages as $image) {
            // 1.1. Kiểm tra Cloudinary URL có sẵn không
            $imageUrl = $image->imageUrl;
            if (empty($image->image_path) || empty($imageUrl)) {
                Log::error("Cloudinary URL không khả dụng: {$image->image_path}");
                continue; // Bỏ qua ảnh này, tiếp tục với ảnh khác
            }

            // 1.2. Tạo URL endpoint để upload ảnh
            $uploadUrl = "https://graph.facebook.com/v23.0/{$pageId}/photos";

            try {
                // 1.3. Download ảnh từ Cloudinary
                $fileContent = Http::timeout(30)->get($imageUrl)->body();

                if (empty($fileContent)) {
                    Log::error("Không thể tải ảnh từ Cloudinary: {$imageUrl}");
                    continue;
                }

                // 1.4. Upload ảnh lên Facebook (published = false để không đăng riêng lẻ)
                $uploadResponse = Http::attach(
                    'source',                        // Tên field cho file
                    $fileContent,                    // Nội dung file
                    basename($image->image_path)     // Tên file từ Cloudinary public_id
                )->post($uploadUrl, [
                    'published' => 'false',          // Không đăng ảnh riêng lẻ
                    'access_token' => $accessToken,
                ]);

                // 1.5. Xử lý response từ Facebook
                if ($uploadResponse->successful()) {
                    // Lưu Media ID để dùng cho bước 2
                    $mediaFbIds[] = ['media_fbid' => $uploadResponse->json()['id']];
                } else {
                    Log::error("Upload ảnh thất bại cho {$imageUrl}: " . $uploadResponse->body());
                }

            } catch (\Exception $e) {
                Log::error("Lỗi tải ảnh từ Cloudinary {$imageUrl}: " . $e->getMessage());
            }
        }

        // 1.6. Kiểm tra có ít nhất 1 ảnh upload thành công không
        if (empty($mediaFbIds)) {
            Log::error("Không có ảnh nào upload thành công cho ad_id: {$ad->id}");
            return ['success' => false];
        }

        // BƯỚC 2: Tạo post với các ảnh đã upload
        
        // 2.1. Chuyển đổi thời gian scheduled sang UTC
        $publishTimeUtc = Carbon::parse($schedule->scheduled_time)->timezone('UTC');

        // 2.2. Chuẩn bị parameters cho Facebook Feed API
        $params = [
            'message' => $message,
            'attached_media' => json_encode($mediaFbIds), // Danh sách Media IDs dạng JSON
            'access_token' => $accessToken,
        ];

        // 2.3. Kiểm tra logic thời gian để quyết định đăng ngay hay schedule
        $minutesUntilPublish = Carbon::now('UTC')->diffInMinutes($publishTimeUtc, false);
        
        // Nếu thời gian đăng >= 10 phút nữa và là thời gian tương lai
        if ($minutesUntilPublish >= 10 && $publishTimeUtc->isFuture()) {
            // Schedule bài đăng cho tương lai
            $params['published'] = 'false';
            $params['scheduled_publish_time'] = $publishTimeUtc->timestamp;
        } else {
            // Đăng ngay lập tức
            $params['published'] = 'true';
        }

        // 2.4. Tạo URL endpoint cho Facebook Feed API
        $feedUrl = "https://graph.facebook.com/v23.0/{$pageId}/feed";
        
        // 2.5. Gửi request tới Facebook API
        $response = Http::asForm()->post($feedUrl, $params);

        // 2.6. Log lỗi nếu có
        if (!$response->successful()) {
            Log::error("Facebook Feed API Error: " . $response->body());
        }

        // 2.7. Trả về kết quả
        return $response->successful()
            ? ['success' => true, 'facebook_post_id' => $response->json()['id'] ?? null]
            : ['success' => false];
    }
}
