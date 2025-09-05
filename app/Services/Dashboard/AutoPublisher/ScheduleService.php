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

    public function postToPage($scheduleId): bool
    {
        try {
            $schedule = $this->scheduleRepository->find($scheduleId);

            if (! $schedule) {
                Log::error("Không tìm thấy lịch trình: {$scheduleId}");
                return false;
            }

            $ad = $schedule->ad;
            $userPage = $schedule->userPage;

            if (! $ad || ! $userPage) {
                Log::error("Không tìm thấy Quảng cáo hoặc Trang người dùng cho lịch trình: {$scheduleId}");
                $this->scheduleRepository->update($scheduleId, ['status' => 'failed']);
                return false;
            }

            $pageId = $userPage->page_id;
            $accessToken = $userPage->page_access_token;

            if (empty($accessToken)) {
                Log::error("Access token của page này trống: {$pageId}");
                $this->scheduleRepository->update($scheduleId, ['status' => 'failed']);
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

                $this->scheduleRepository->update($scheduleId, [
                    'status' => 'posted',
                    'facebook_post_id' => $responseData['id'] ?? null
                ]);

                $ad->update([
                    'status' => 'approved'
                ]);

                return true;
            } else {
                $errorData = $response->json();

                $this->scheduleRepository->update($scheduleId, ['status' => 'failed']);
                return false;
            }

        } catch (\Exception $e) {
            Log::error("Exception in postToPage for schedule {$scheduleId}: " . $e->getMessage());
            $this->scheduleRepository->update($scheduleId, ['status' => 'failed']);
            return false;
        }
    }
}