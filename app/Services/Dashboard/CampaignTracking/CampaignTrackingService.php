<?php

namespace App\Services\Dashboard\CampaignTracking;

use App\Models\Dashboard\AutoPublisher\AdSchedule;
use App\Services\BaseService;
use App\Models\Dashboard\CampaignTracking\CampaignAnalytics;
use App\Models\Dashboard\CampaignTracking\PostComment;
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
   * Lấy dữ liệu Surface và Insights cho một post
   */
  public function fetchPostAnalytics($postId, $adSchedule): array
  {
    try {
      $userPage = $adSchedule->userPage;

      if (!$userPage || empty($userPage->page_access_token)) {
        Log::warning("Missing access token for Page ID: {$adSchedule->user_page_id}");
        return ['success' => false, 'error' => 'Không có access token cho Facebook Page'];
      }

      $surfaceData = $this->fetchSurfaceData($postId, $userPage);

      if (!$surfaceData['success']) {
        Log::error("Failed to fetch surface data for post {$postId}: " . $surfaceData['error']);
        return $surfaceData;
      }

      $saveResult = $this->saveAnalyticsData($adSchedule, $surfaceData);

      if (!$saveResult['success']) {
        Log::error("Failed to save analytics data: " . $saveResult['error']);
      }

      return $saveResult;

    } catch (\Exception $e) {
      Log::error("Exception in fetchPostAnalytics: " . $e->getMessage());
      return ['success' => false, 'error' => $e->getMessage()];
    }
  }

  /**
   * Lấy detailed surface data từ Facebook API
   */
  private function fetchSurfaceData($postId, $userPage): array
  {
    try {
      $url = "https://graph.facebook.com/v23.0/{$postId}";
      $params = [
        'fields' => 'id,message,created_time,updated_time,permalink_url,status_type,shares,'
          . 'reactions.summary(true).limit(0),'
          . 'reactions.type(LIKE).limit(0).summary(true).as(like_count),'
          . 'reactions.type(LOVE).limit(0).summary(true).as(love_count),'
          . 'reactions.type(HAHA).limit(0).summary(true).as(haha_count),'
          . 'reactions.type(WOW).limit(0).summary(true).as(wow_count),'
          . 'reactions.type(SAD).limit(0).summary(true).as(sad_count),'
          . 'reactions.type(ANGRY).limit(0).summary(true).as(angry_count),'
          . 'comments.limit(50).summary(true){id,message,created_time,like_count,from{name,id},parent}',
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
          'id' => $data['id'] ?? null,
          'message' => $data['message'] ?? null,
          'created_time' => $data['created_time'] ?? null,
          'updated_time' => $data['updated_time'] ?? null,
          'permalink_url' => $data['permalink_url'] ?? null,
          'status_type' => $data['status_type'] ?? null,
          'shares' => $data['shares']['count'] ?? 0,
          'reactions_total' => $data['reactions']['summary']['total_count'] ?? 0,
          'reactions_like' => $data['like_count']['summary']['total_count'] ?? 0,
          'reactions_love' => $data['love_count']['summary']['total_count'] ?? 0,
          'reactions_haha' => $data['haha_count']['summary']['total_count'] ?? 0,
          'reactions_wow' => $data['wow_count']['summary']['total_count'] ?? 0,
          'reactions_sorry' => $data['sad_count']['summary']['total_count'] ?? 0,
          'reactions_anger' => $data['angry_count']['summary']['total_count'] ?? 0,
          'comments_count' => $data['comments']['summary']['total_count'] ?? 0,
          'comments_data' => $data['comments']['data'] ?? [],
        ],
      ];

    } catch (\Exception $e) {
      Log::error("Exception in fetchSurfaceData: " . $e->getMessage());
      return ['success' => false, 'error' => $e->getMessage()];
    }
  }

  /**
   * Lưu dữ liệu analytics và normalize comments vào post_comments table
   */
  private function saveAnalyticsData($adSchedule, $surfaceData): array
  {
    try {
      $campaignId = $adSchedule->campaign_id;
      $today = now()->toDateString();

      // Upsert analytics record
      $analytics = CampaignAnalytics::firstOrNew([
        'ad_schedule_id' => $adSchedule->id,
        'insights_date' => $today,
      ], [
        'campaign_id' => $campaignId,
      ]);

      if ($surfaceData['success'] && isset($surfaceData['data'])) {
        $d = $surfaceData['data'];
        $analytics->fill([
          'status_type' => $d['status_type'],
          'post_message' => $d['message'],
          'post_created_time' => $d['created_time']
            ? now()->createFromFormat('Y-m-d\TH:i:sP', $d['created_time'])
            : null,
          'post_updated_time' => $d['updated_time']
            ? now()->createFromFormat('Y-m-d\TH:i:sP', $d['updated_time'])
            : null,
          'post_permalink_url' => $d['permalink_url'],
          'reactions_total' => $d['reactions_total'],
          'reactions_like' => $d['reactions_like'],
          'reactions_love' => $d['reactions_love'],
          'reactions_wow' => $d['reactions_wow'],
          'reactions_haha' => $d['reactions_haha'],
          'reactions_sorry' => $d['reactions_sorry'],
          'reactions_anger' => $d['reactions_anger'],
          'comments' => $d['comments_count'],
          'shares' => $d['shares'],
        ]);
      }

      $analytics->fetched_at = now();
      $analytics->insights_date = $today;
      $analytics->save();

      if (!empty($surfaceData['data']['comments_data'])) {
        $this->syncPostComments($analytics->id, $surfaceData['data']['comments_data']);
      }

      return [
        'success' => true,
        'analytics_id' => $analytics->id,
        'message' => 'Analytics data saved successfully',
      ];

    } catch (\Exception $e) {
      Log::error("Exception in saveAnalyticsData: " . $e->getMessage());
      return ['success' => false, 'error' => $e->getMessage()];
    }
  }

  /**
   * Sync comments từ Facebook API vào post_comments table (upsert by facebook_comment_id)
   */
  private function syncPostComments(int $analyticsId, array $comments): void
  {
    foreach ($comments as $comment) {
      if (empty($comment['id'])) {
        continue;
      }

      PostComment::updateOrCreate(
        ['facebook_comment_id' => $comment['id']],
        [
          'campaign_analytics_id' => $analyticsId,
          'parent_comment_id' => $comment['parent']['id'] ?? null,
          'message' => $comment['message'] ?? '',
          'from_facebook_id' => $comment['from']['id'] ?? null,
          'from_name' => $comment['from']['name'] ?? null,
          'like_count' => $comment['like_count'] ?? 0,
          'comment_created_at' => isset($comment['created_time'])
            ? now()->createFromFormat('Y-m-d\TH:i:sP', $comment['created_time'])
            : null,
        ]
      );
    }
  }

  /**
   * Sync analytics cho nhiều campaigns
   */
  public function syncCampaignAnalytics($campaignIds = null): array
  {
    try {
      $query = AdSchedule::with(['campaign', 'userPage'])
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

        usleep(500000); // 0.5s delay to avoid rate limit
      }

      return [
        'success' => true,
        'posts_processed' => $processed,
        'total_posts' => $total,
        'errors' => $errors,
      ];

    } catch (\Exception $e) {
      Log::error("Exception in syncCampaignAnalytics: " . $e->getMessage());
      return ['success' => false, 'error' => $e->getMessage()];
    }
  }
}
