<?php

namespace App\Services\Dashboard;

use App\Repositories\Interfaces\Dashboard\AutoPublisherInterface;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class AutoPublisherService extends BaseService
{
    public function __construct(private AutoPublisherInterface $autoPublisherRepository) {}

    public function create($attributes)
    {
        return $this->autoPublisherRepository->create($attributes);
    }

    public function update($id, $attributes)
    {
        return $this->autoPublisherRepository->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->autoPublisherRepository->delete($id);
    }

    public function find($id)
    {
        return $this->autoPublisherRepository->find($id);
    }

    public function get($conditions = [])
    {
        return $this->autoPublisherRepository->get($conditions);
    }

    public function search($search)
    {
        $search = array_filter($search, fn ($value) => ! is_null($value) && $value !== '');

        return $this->autoPublisherRepository->search($search);
    }

    public function postToPage($scheduleId): bool
    {
        try {
            $schedule = $this->autoPublisherRepository->find($scheduleId);

            if (! $schedule) {
                Log::error("Không tìm thấy lịch trình: {$scheduleId}");
                return false;
            }

            $ad = $schedule->ad;
            $userPage = $schedule->userPage;

            if (! $ad || ! $userPage) {
                Log::error("Không tìm thấy Quảng cáo hoặc Trang người dùng cho lịch trình: {$scheduleId}");
                $this->autoPublisherRepository->update($scheduleId, ['status' => 'failed']);
                return false;
            }

            $pageId = $userPage->page_id;
            $accessToken = $userPage->page_access_token;

            if (empty($accessToken)) {
                Log::error("Access token của page này trống: {$pageId}");
                $this->autoPublisherRepository->update($scheduleId, ['status' => 'failed']);
                return false;
            }

            $messageParts = [];
            if (!empty($ad->ad_title)) {
                $messageParts[] = $ad->ad_title;
            }
            if (!empty($ad->ad_content)) {
                $messageParts[] = $ad->ad_content;
            }
            if (!empty($ad->hashtags)) {
                $messageParts[] = $ad->hashtags;
            }

            $message = implode("\n\n", $messageParts);

            $publishTimeUtc = Carbon::parse($schedule->scheduled_time, 'Asia/Ho_Chi_Minh')
                ->timezone('UTC')
                ->timestamp;

            $params = [
                'message' => $message,
                'access_token' => $accessToken,
            ];

            // Nếu thời gian đăng cách xa hiện tại >= 10 phút thì schedule, ngược lại post luôn
            if (Carbon::now('UTC')->diffInMinutes(Carbon::createFromTimestamp($publishTimeUtc), false) >= 10) {
                $params['published'] = 'false';
                $params['scheduled_publish_time'] = $publishTimeUtc;
            } else {
                $params['published'] = 'true';
            }

            $url = "https://graph.facebook.com/v23.0/{$pageId}/feed";

            $response = Http::asForm()->post($url, $params);

            if ($response->successful()) {
                $responseData = $response->json();
                Log::info("Post successful for schedule {$scheduleId}: ", $responseData);

                $this->autoPublisherRepository->update($scheduleId, [
                    'status' => 'posted',
                    'facebook_post_id' => $responseData['id'] ?? null
                ]);
                return true;
            } else {
                $errorData = $response->json();
                Log::error("Facebook API error for schedule {$scheduleId}: ", $errorData);

                $this->autoPublisherRepository->update($scheduleId, ['status' => 'failed']);
                return false;
            }

        } catch (\Exception $e) {
            Log::error("Exception in postToPage for schedule {$scheduleId}: " . $e->getMessage());
            $this->autoPublisherRepository->update($scheduleId, ['status' => 'failed']);
            return false;
        }
    }
}