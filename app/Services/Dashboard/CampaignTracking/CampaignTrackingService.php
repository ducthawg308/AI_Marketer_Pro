<?php

namespace App\Services\Dashboard\CampaignTracking;

use App\Services\BaseService;
use App\Repositories\Interfaces\Dashboard\CampaignTracking\CampaignTrackingInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CampaignTrackingService extends BaseService
{
    protected $campaignTrackingRepository;

    public function __construct(CampaignTrackingInterface $campaignTrackingRepository)
    {
        $this->campaignTrackingRepository = $campaignTrackingRepository;
    }
    /**
     * Lấy dữ liệu Surfaces và Insights cho một post
     *
     * @param string $postId Facebook Post ID
     * @param object $userPage Thông tin Facebook Page
     * @param object $campaignAnalytics Record để update
     * @return array
     */
    public function fetchPostAnalytics($postId, $adSchedule): array
    {
        try {
            $userPage = $adSchedule->userPage;

            if (!$userPage || empty($userPage->page_access_token)) {
                Log::warning("Missing access token for Page ID: {$adSchedule->user_page_id}");
                return ['success' => false, 'error' => 'Không có access token cho Facebook Page'];
            }

            // 1. Lấy Surface Data (message, created_time, shares, comments, reactions)
            $surfaceData = $this->fetchSurfaceData($postId, $userPage);

            if (!$surfaceData['success']) {
                Log::error("Failed to fetch surface data for post {$postId}: " . $surfaceData['error']);
                return $surfaceData;
            }

            // 2. Save surface data to database
            $saveResult = $this->campaignTrackingRepository->saveAnalyticsData($adSchedule, $surfaceData);

            if (!$saveResult['success']) {
                Log::error("Failed to save analytics data: " . $saveResult['error']);
            }

            return $saveResult;

        } catch (\Exception $e) {
            Log::error("Exception in FacebookAnalyticsService::fetchPostAnalytics: " . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * API Lấy detailed surface data với reaction breakdown và comments
     */
    private function fetchSurfaceData($postId, $userPage): array
    {
        try {
            $url = "https://graph.facebook.com/v23.0/{$postId}";
            $params = [
                'fields' => 'id,message,created_time,updated_time,permalink_url,status_type,shares,reactions.summary(true).limit(0),reactions.type(LIKE).limit(0).summary(true).as(like_count),reactions.type(LOVE).limit(0).summary(true).as(love_count),reactions.type(HAHA).limit(0).summary(true).as(haha_count),reactions.type(WOW).limit(0).summary(true).as(wow_count),reactions.type(SAD).limit(0).summary(true).as(sad_count),reactions.type(ANGRY).limit(0).summary(true).as(angry_count),comments.limit(10).summary(true){message,created_time,like_count,from{name,id}}',
                'access_token' => $userPage->page_access_token,
            ];

            $response = Http::timeout(30)->get($url, $params);

            if (!$response->successful()) {
                return ['success' => false, 'error' => 'Facebook API Error: ' . $response->body()];
            }

            $data = $response->json();

            return [
                'success' => true,
                'data' => [
                    // Basic post info
                    'id' => $data['id'] ?? null,
                    'message' => $data['message'] ?? null,
                    'created_time' => $data['created_time'] ?? null,
                    'updated_time' => $data['updated_time'] ?? null,
                    'permalink_url' => $data['permalink_url'] ?? null,
                    'status_type' => $data['status_type'] ?? null,

                    // Shares
                    'shares' => $data['shares']['count'] ?? 0,

                    // Reactions breakdown
                    'reactions_total' => $data['reactions']['summary']['total_count'] ?? 0,
                    'reactions_like' => $data['like_count']['summary']['total_count'] ?? 0,
                    'reactions_love' => $data['love_count']['summary']['total_count'] ?? 0,
                    'reactions_haha' => $data['haha_count']['summary']['total_count'] ?? 0,
                    'reactions_wow' => $data['wow_count']['summary']['total_count'] ?? 0,
                    'reactions_sorry' => $data['sad_count']['summary']['total_count'] ?? 0, // Map sad to sorry
                    'reactions_anger' => $data['angry_count']['summary']['total_count'] ?? 0,

                    // Comments count
                    'comments_count' => $data['comments']['summary']['total_count'] ?? 0,

                    // Comments data array
                    'comments_data' => isset($data['comments']['data']) ? $this->formatCommentsData($data['comments']['data']) : [],
                ]
            ];

        } catch (\Exception $e) {
            Log::error("Exception in fetchSurfaceData: " . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Format comments data từ Facebook API
     */
    private function formatCommentsData($comments): array
    {
        if (!is_array($comments)) {
            return [];
        }

        return array_map(function ($comment) {
            return [
                'id' => $comment['id'] ?? null,
                'message' => $comment['message'] ?? '',
                'created_time' => $comment['created_time'] ?? null,
                'like_count' => $comment['like_count'] ?? 0,
                'from' => [
                    'id' => $comment['from']['id'] ?? null,
                    'name' => $comment['from']['name'] ?? '',
                ],
            ];
        }, $comments);
    }

    /**
     * Lưu dữ liệu analytics vào database
     */
    private function saveAnalyticsData($adSchedule, $surfaceData): array
    {
        try {
            $campaignId = $adSchedule->campaign_id;
            $today = now()->toDateString();

            // Find existing analytics record or create new
            $analytics = CampaignAnalytics::firstOrNew([
                'ad_schedule_id' => $adSchedule->id,
                'insights_date' => $today,
            ], [
                'campaign_id' => $campaignId,
                'facebook_post_id' => $adSchedule->facebook_post_id,
            ]);

            // Update surface data with detailed reaction breakdown and comments
            if ($surfaceData['success'] && isset($surfaceData['data'])) {
                $analytics->fill([
                    // Basic post info
                    'status_type' => $surfaceData['data']['status_type'],
                    'post_message' => $surfaceData['data']['message'],
                    'post_created_time' => $surfaceData['data']['created_time'] ?
                        now()->createFromFormat('Y-m-d\TH:i:sP', $surfaceData['data']['created_time']) : null,
                    'post_updated_time' => $surfaceData['data']['updated_time'] ?
                        now()->createFromFormat('Y-m-d\TH:i:sP', $surfaceData['data']['updated_time']) : null,
                    'post_permalink_url' => $surfaceData['data']['permalink_url'],

                    // Reactions breakdown
                    'reactions_total' => $surfaceData['data']['reactions_total'],
                    'reactions_like' => $surfaceData['data']['reactions_like'],
                    'reactions_love' => $surfaceData['data']['reactions_love'],
                    'reactions_wow' => $surfaceData['data']['reactions_wow'],
                    'reactions_haha' => $surfaceData['data']['reactions_haha'],
                    'reactions_sorry' => $surfaceData['data']['reactions_sorry'],
                    'reactions_anger' => $surfaceData['data']['reactions_anger'],

                    // Comments & Shares
                    'comments' => $surfaceData['data']['comments_count'],
                    'shares' => $surfaceData['data']['shares'],

                    // Detailed comments data
                    'comments_data' => $surfaceData['data']['comments_data'],
                ]);
            }

            // Update fetched timestamp
            $analytics->fetched_at = now();
            $analytics->insights_date = $today;

            $analytics->save();

            return [
                'success' => true,
                'analytics_id' => $analytics->id,
                'message' => 'Analytics data saved successfully'
            ];

        } catch (\Exception $e) {
            Log::error("Exception in saveAnalyticsData: " . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Sync analytics cho nhiều campaigns
     */
    public function syncCampaignAnalytics($campaignIds = null): array
    {
        try {
            $query = \App\Models\Dashboard\AutoPublisher\AdSchedule::with(['campaign', 'userPage'])
                ->whereNotNull('facebook_post_id')
                ->where('status', 'posted');

            if ($campaignIds) {
                $query->whereIn('campaign_id', (array) $campaignIds);
            }

            $schedules = $query->get();
            $total = $schedules->count();
            $processed = 0;
            $errors = [];

            foreach ($schedules as $schedule) {
                $result = $this->fetchPostAnalytics($schedule->facebook_post_id, $schedule);

                if ($result['success']) {
                    $processed++;
                } else {
                    $errors[] = "Schedule {$schedule->id}: " . $result['error'];
                }

                // Small delay để tránh rate limit
                usleep(500000); // 0.5 seconds
            }

            return [
                'success' => true,
                'posts_processed' => $processed,
                'total_posts' => $total,
                'errors' => $errors
            ];

        } catch (\Exception $e) {
            Log::error("Exception in syncCampaignAnalytics: " . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
