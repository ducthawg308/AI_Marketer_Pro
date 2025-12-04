<?php

namespace App\Services\Dashboard;

use App\Models\Dashboard\CampaignAnalytics;
use App\Services\BaseService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FacebookAnalyticsService extends BaseService
{
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
        Log::info("🔍 Starting analytics fetch for Post ID: {$postId}, Campaign ID: {$adSchedule->campaign_id}, Schedule ID: {$adSchedule->id}");

        try {
            $userPage = $adSchedule->userPage;

            if (!$userPage || empty($userPage->page_access_token)) {
                Log::warning("❌ Missing access token for Page ID: {$adSchedule->user_page_id}");
                return ['success' => false, 'error' => 'Không có access token cho Facebook Page'];
            }

            Log::info("📘 Using Facebook Page: {$userPage->page_name} (ID: {$userPage->page_id})");

            // 1. Lấy Surface Data (message, created_time, shares, comments, reactions)
            Log::info("📄 Fetching Surface Data for post: {$postId}");
            $surfaceData = $this->fetchSurfaceData($postId, $userPage);

            if (!$surfaceData['success']) {
                Log::error("❌ Failed to fetch surface data for post {$postId}: " . $surfaceData['error']);
                return $surfaceData;
            }

            Log::info("✅ Surface Data fetched successfully", [
                'post_message_length' => strlen($surfaceData['data']['message'] ?? ''),
                'shares' => $surfaceData['data']['shares'],
                'comments' => $surfaceData['data']['comments'],
                'reactions_total' => $surfaceData['data']['reactions_total']
            ]);

            // 2. Lấy Insights Data
            Log::info("📊 Fetching Insights Data for post: {$postId}");
            $insightsData = $this->fetchInsightsData($postId, $userPage);

            if (!$insightsData['success']) {
                Log::warning("⚠️ Failed to fetch insights data for post {$postId}: " . $insightsData['error'] . " - Continuing with surface data only");
                // Vẫn update surface data nếu insights fail
            } else {
                Log::info("✅ Insights Data fetched successfully", [
                    'reach' => $insightsData['data']['reach'] ?? 0,
                    'impressions' => $insightsData['data']['impressions'] ?? 0,
                    'engaged_users' => $insightsData['data']['engaged_users'] ?? 0,
                    'clicks' => $insightsData['data']['clicks'] ?? 0,
                    'negative_feedback' => $insightsData['data']['negative_feedback'] ?? 0
                ]);
            }

            // 3. Kết hợp data và save/update database
            Log::info("💾 Saving analytics data to database");
            $saveResult = $this->saveAnalyticsData($adSchedule, $surfaceData, $insightsData);

            if ($saveResult['success']) {
                Log::info("✅ Analytics data saved successfully for post {$postId}", [
                    'analytics_id' => $saveResult['analytics_id'],
                    'surface_data_saved' => $surfaceData['success'],
                    'insights_data_saved' => $insightsData['success']
                ]);
            } else {
                Log::error("❌ Failed to save analytics data: " . $saveResult['error']);
            }

            return $saveResult;

        } catch (\Exception $e) {
            Log::error("💥 Exception in FacebookAnalyticsService::fetchPostAnalytics for post {$postId}: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * API Lấy Surface Data: message, created_time, permalink_url, shares, comments, reactions
     */
    private function fetchSurfaceData($postId, $userPage): array
    {
        try {
            $url = "https://graph.facebook.com/v23.0/{$postId}";
            $params = [
                'fields' => 'message,created_time,permalink_url,shares,comments.summary(true).limit(0),likes.summary(true).limit(0),reactions.summary(true).limit(0)',
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
                    'message' => $data['message'] ?? null,
                    'created_time' => $data['created_time'] ?? null,
                    'permalink_url' => $data['permalink_url'] ?? null,
                    'shares' => $data['shares']['count'] ?? 0,
                    'comments' => $data['comments']['summary']['total_count'] ?? 0,
                    'reactions_total' => $data['reactions']['summary']['total_count'] ?? 0,
                    'likes' => $data['likes']['summary']['total_count'] ?? 0,
                ]
            ];

        } catch (\Exception $e) {
            Log::error("Exception in fetchSurfaceData: " . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * API Lấy Insights (Deep Metrics)
     */
    private function fetchInsightsData($postId, $userPage): array
    {
        try {
            // Thử metrics theo priority - bắt đầu với basic metrics trước
            $metricSets = [
                // Set 1: Basic metrics (thường available sớm hơn)
                'post_impressions_unique,post_impressions,post_engaged_users',
                // Set 2: Added clicks if available
                'post_impressions_unique,post_impressions,post_engaged_users,post_clicks',
                // Set 3: Full set (có thể fail if too new)
                'post_impressions_unique,post_impressions,post_engaged_users,post_clicks,post_negative_feedback'
            ];

            $bestResult = null;
            $lastError = null;

            foreach ($metricSets as $metrics) {
                $url = "https://graph.facebook.com/v23.0/{$postId}/insights";
                $params = [
                    'metric' => $metrics,
                    'period' => 'lifetime',
                    'access_token' => $userPage->page_access_token,
                ];

                $response = Http::timeout(30)->get($url, $params);
                $data = $response->json();

                if ($response->successful()) {
                    // Parse data and continue to next set if we can get more metrics
                    $insights = isset($data['data']) ? $data['data'] : [];
                    $parsed = $this->parseInsightsData($insights, $metrics);

                    // If we got some data and this set has more metrics, save it but try next set
                    if (!empty($parsed) && $metrics != end($metricSets)) {
                        $bestResult = [
                            'success' => true,
                            'data' => $parsed,
                            'raw_response' => $data,
                            'metrics_used' => $metrics
                        ];
                        continue; // Try next set with more metrics
                    }

                    // Return whatever we got (best result or current)
                    if ($bestResult) {
                        return $bestResult;
                    }

                    return [
                        'success' => true,
                        'data' => $parsed,
                        'raw_response' => $data,
                        'metrics_used' => $metrics
                    ];
                } else {
                    $errorData = $data['error'] ?? [];
                    $errorCode = $errorData['code'] ?? null;
                    $errorMsg = $errorData['message'] ?? 'Unknown error';

                    // Check specific error codes
                    if ($errorCode == 100 && strpos($errorMsg, 'valid insights metric') !== false) {
                        // Invalid metric, try simpler set
                        Log::warning("Invalid metric in set: {$metrics}, trying simpler set...", [
                            'post_id' => $postId,
                            'error' => $errorMsg
                        ]);
                        $lastError = $errorMsg;
                        continue;
                    }

                    if ($errorCode == 200) {
                        // Permission issue or data not available yet
                        return [
                            'success' => false,
                            'error' => "Insights data not available yet: {$errorMsg} (Post may be too new - wait 24-48h)",
                            'reason' => 'post_too_new'
                        ];
                    }

                    // Other errors - stop trying
                    return ['success' => false, 'error' => 'Facebook Insights API Error: ' . $response->body()];
                }
            }

            // If we tried all sets and got partial results, return the best
            if ($bestResult) {
                Log::info("Using partial insights data for post {$postId}", [
                    'metrics_used' => $bestResult['metrics_used'],
                    'data_count' => count($bestResult['data'])
                ]);
                return $bestResult;
            }

            // All metrics failed
            return [
                'success' => false,
                'error' => 'No insights metrics available: ' . ($lastError ?: 'Unknown error'),
                'reason' => 'no_metrics_available'
            ];

        } catch (\Exception $e) {
            Log::error("Exception in fetchInsightsData for post {$postId}: " . $e->getMessage(), [
                'post_id' => $postId,
                'trace' => $e->getTraceAsString()
            ]);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Parse insights data from Facebook response
     */
    private function parseInsightsData($insights, $metricsUsed): array
    {
        $parsed = [];

        foreach ($insights as $insight) {
            $metricName = $insight['name'] ?? '';
            $value = isset($insight['values'][0]['value']) ? $insight['values'][0]['value'] : 0;

            // Handle different metric name formats
            switch ($metricName) {
                case 'post_impressions_unique':
                case 'impressions_unique': // Fallback format
                    $parsed['reach'] = (int) $value;
                    break;
                case 'post_impressions':
                case 'impressions': // Fallback format
                    $parsed['impressions'] = (int) $value;
                    break;
                case 'post_engaged_users':
                case 'engaged_users': // Fallback format
                    $parsed['engaged_users'] = (int) $value;
                    break;
                case 'post_clicks':
                case 'clicks': // Fallback format
                    $parsed['clicks'] = (int) $value;
                    break;
                case 'post_negative_feedback':
                case 'negative_feedback': // Fallback format
                    $parsed['negative_feedback'] = (int) $value;
                    break;
            }
        }

        Log::info("Parsed insights data", [
            'metrics_used' => $metricsUsed,
            'parsed_fields' => array_keys($parsed),
            'data' => $parsed
        ]);

        return $parsed;
    }

    /**
     * Lưu dữ liệu analytics vào database
     */
    private function saveAnalyticsData($adSchedule, $surfaceData, $insightsData): array
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

            // Update surface data
            if ($surfaceData['success'] && isset($surfaceData['data'])) {
                $analytics->fill([
                    'post_message' => $surfaceData['data']['message'],
                    'post_created_time' => $surfaceData['data']['created_time'] ? now()->createFromFormat('Y-m-d\TH:i:sP', $surfaceData['data']['created_time']) : null,
                    'post_permalink_url' => $surfaceData['data']['permalink_url'],
                    'shares' => $surfaceData['data']['shares'],
                    'comments' => $surfaceData['data']['comments'],
                    'reactions_total' => $surfaceData['data']['reactions_total'],
                    'reactions_like' => $surfaceData['data']['likes'], // Map like to reactions_like for now
                ]);
            }

            // Update insights data
            if ($insightsData['success'] && isset($insightsData['data'])) {
                $analytics->fill($insightsData['data']);

                // Store raw response
                if (isset($insightsData['raw_response'])) {
                    $analytics->raw_insights = $insightsData['raw_response'];
                }
            }

            // Calculate rates
            $analytics->updateEngagementRate();
            $analytics->updateClickThroughRate();

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
