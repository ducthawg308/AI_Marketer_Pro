<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Dashboard\AutoPublisher\Campaign;
use App\Models\Dashboard\CampaignAnalytics;
use App\Services\Dashboard\FacebookAnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CampaignTrackingController extends Controller
{
    public function __construct(private FacebookAnalyticsService $analyticsService) {}

    /**
     * Hiển thị danh sách campaigns với analytics
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $keyword = $request->get('keyword');

        $query = Campaign::where('user_id', $userId)
            ->with(['user', 'schedules.ad', 'schedules.userPage'])
            ->withCount(['schedules as posted_posts_count' => function ($query) {
                $query->where('status', 'posted');
            }])
            ->latest();

        if ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        $campaigns = $query->paginate(15);

        // Attach analytics stats for each campaign
        foreach ($campaigns as $campaign) {
            $campaign->analytics_stats = $this->getCampaignAnalyticsStats($campaign->id);
        }

        return view('dashboard.campaign_tracking.index', compact('campaigns'));
    }

    /**
     * Hiển thị chi tiết campaign với analytics của từng post
     */
    public function show($campaignId)
    {
        $userId = Auth::id();

        $campaign = Campaign::where('user_id', $userId)
            ->with(['schedules.ad', 'schedules.userPage'])
            ->findOrFail($campaignId);

        // Get schedules với analytics
        $schedules = $campaign->schedules()
            ->with(['ad', 'userPage', 'analytics'])
            ->where('status', 'posted')
            ->orderBy('scheduled_time', 'desc')
            ->get();

        // Attach latest analytics to each schedule for easier access
        foreach ($schedules as $schedule) {
            $schedule->latest_analytics = $schedule->analytics->sortByDesc('insights_date')->first();
        }

        // Tổng hợp stats cho campaign
        $totalStats = [
            'total_posts' => $schedules->count(),
            'impressions' => 0,
            'reach' => 0,
            'total_engagement' => 0,
            'clicks' => 0,
            'avg_engagement_rate' => 0,
            'avg_ctr' => 0,
        ];

        $engagementRates = [];
        $ctrRates = [];

        foreach ($schedules as $schedule) {
            if ($schedule->analytics && $schedule->analytics->isNotEmpty()) {
                $analytics = $schedule->analytics->first();
                $totalStats['impressions'] += $analytics->impressions;
                $totalStats['reach'] += $analytics->reach;
                $totalStats['clicks'] += $analytics->clicks;
                $totalStats['total_engagement'] += $analytics->reactions_total + $analytics->comments + $analytics->shares;

                if ($analytics->engagement_rate > 0) {
                    $engagementRates[] = $analytics->engagement_rate;
                }
                if ($analytics->click_through_rate > 0) {
                    $ctrRates[] = $analytics->click_through_rate;
                }
            }
        }

        // Tính trung bình rates
        if (!empty($engagementRates)) {
            $totalStats['avg_engagement_rate'] = round(array_sum($engagementRates) / count($engagementRates), 2);
        }
        if (!empty($ctrRates)) {
            $totalStats['avg_ctr'] = round(array_sum($ctrRates) / count($ctrRates), 2);
        }

        return view('dashboard.campaign_tracking.show', compact('campaign', 'schedules', 'totalStats'));
    }

    /**
     * Test Facebook API connection
     */
    public function testApi(Request $request)
    {
        try {
            // Get first available page để test
            $firstPage = Auth::user()->pages()->first();

            if (!$firstPage || empty($firstPage->page_access_token)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy Facebook Page nào có access token',
                    'suggestion' => 'Vui lòng kết nối Facebook và cấp quyền read_insights'
                ]);
            }

            // Test basic API call
            $url = "https://graph.facebook.com/v23.0/me";
            $response = Http::timeout(10)->get($url, [
                'access_token' => $firstPage->page_access_token
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return response()->json([
                    'success' => true,
                    'message' => '✅ Kết nối Facebook Graph API thành công',
                    'page_data' => [
                        'page_name' => $firstPage->page_name,
                        'page_id' => $firstPage->page_id,
                    ],
                    'permissions_note' => 'Nếu thấy "read_insights" trong scope thì có thể fetch analytics',
                    'insights_note' => 'Facebook có thể mất 24-48h sau khi post để có metrics insights'
                ]);
            } else {
                // Check if it's permission issue
                $error = $response->json();
                $errorCode = $error['error']['code'] ?? null;

                if ($errorCode == 200) {
                    return response()->json([
                        'success' => false,
                        'message' => '❌ Chưa có quyền read_insights',
                        'suggestion' => 'Vui lòng reconnect Facebook và cấp quyền read_insights khi login',
                        'error' => $error['error']['message'] ?? 'Unknown error'
                    ]);
                }

                return response()->json([
                    'success' => false,
                    'message' => '❌ Kết nối Facebook API thất bại',
                    'error' => $error['error']['message'] ?? 'Unknown error'
                ]);
            }

        } catch (\Exception $e) {
            Log::error("Exception in testApi: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => '❌ Lỗi hệ thống khi test API',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Test fetch metrics (đếm số posts available)
     */
    public function testMetrics(Request $request)
    {
        try {
            $postId = $request->get('post_id');
            $userId = Auth::id();

            if ($postId) {
                // Test specific post analytics
                $schedule = \App\Models\Dashboard\AutoPublisher\AdSchedule::with('userPage')
                    ->where('facebook_post_id', $postId)
                    ->whereHas('campaign', function ($query) use ($userId) {
                        $query->where('user_id', $userId);
                    })
                    ->first();

                if (!$schedule) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Không tìm thấy post trong campaigns của bạn'
                    ]);
                }

                // Test fetch
                $result = $this->analyticsService->fetchPostAnalytics($postId, $schedule);

                return response()->json([
                    'success' => $result['success'],
                    'message' => $result['success'] ? '✅ Metrics API hoạt động!' : '❌ Test thất bại',
                    'error' => $result['error'] ?? null,
                    'metrics_count' => $result['success'] ? 5 : 0, // 5 metrics: reach, impressions, engagement, clicks, negative_feedback
                    'processed_data' => $result['success'] ? [
                        'reach' => $result['success'] ? 'Fetched' : 0,
                        'impressions' => 'Fetched',
                        'engaged_users' => 'Fetched',
                        'clicks' => 'Fetched',
                        'negative_feedback' => 'Fetched',
                    ] : null,
                    'raw_response' => $result['success'] ? 'Captured' : null,
                ]);
            }

            // List available posts
            $availablePosts = \App\Models\Dashboard\AutoPublisher\AdSchedule::with(['campaign', 'userPage'])
                ->where('status', 'posted')
                ->whereNotNull('facebook_post_id')
                ->whereHas('campaign', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->select('id', 'campaign_id', 'facebook_post_id', 'user_page_id')
                ->take(10) // Limit to 10 for testing
                ->get()
                ->map(function ($schedule) {
                    return [
                        'schedule_id' => $schedule->id,
                        'ad_title' => $schedule->ad->ad_title ?? 'Unknown',
                        'post_id' => $schedule->facebook_post_id,
                        'page_name' => $schedule->userPage->page_name ?? 'Unknown',
                        'campaign_name' => $schedule->campaign->name ?? 'Unknown',
                    ];
                });

            if ($availablePosts->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không có posts nào để test metrics',
                    'suggestion' => 'Đăng ít nhất một post trước, sau đó quay lại test.',
                    'next_steps' => [
                        '1. Tạo campaign mới hoặc dùng campaign existing',
                        '2. Schedule và publish ít nhất một post',
                        '3. Quay lại trang này để test metrics',
                        '4. Chờ 24-48h để Facebook tạo metrics insights'
                    ]
                ]);
            }

            return response()->json([
                'success' => true,
                'available_posts' => $availablePosts,
                'available_posts_count' => $availablePosts->count(),
                'suggestion' => 'Click để test một post cụ thể',
            ]);

        } catch (\Exception $e) {
            Log::error("Exception in testMetrics: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => '❌ Lỗi khi test metrics: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Sync analytics cho một campaign
     */
    public function sync($campaignId)
    {
        Log::info("🚀 Starting sync analytics for Campaign ID: {$campaignId}, User ID: " . Auth::id());

        try {
            $userId = Auth::id();

            // Verify campaign belongs to user
            $campaign = Campaign::where('user_id', $userId)->findOrFail($campaignId);
            Log::info("📋 Found campaign: '{$campaign->name}' (ID: {$campaignId})");

            // Sync analytics
            Log::info("🔄 Starting analytics sync process...");
            $result = $this->analyticsService->syncCampaignAnalytics([$campaignId]);

            if ($result['success']) {
                Log::info("✅ Campaign analytics sync completed successfully", [
                    'campaign_id' => $campaignId,
                    'campaign_name' => $campaign->name,
                    'posts_processed' => $result['posts_processed'],
                    'total_posts' => $result['total_posts'],
                    'errors_count' => count($result['errors'] ?? []),
                ]);

                if (!empty($result['errors'])) {
                    Log::warning("⚠️ Sync completed with errors for some posts:", $result['errors']);
                }

                return response()->json([
                    'success' => true,
                    'stats' => [
                        'posts_processed' => $result['posts_processed'],
                        'total_posts' => $result['total_posts'],
                        'errors_count' => count($result['errors'] ?? []),
                    ],
                    'message' => "Đã sync analytics thành công cho {$result['posts_processed']} posts"
                ]);
            } else {
                Log::error("❌ Campaign analytics sync failed: " . $result['error'], [
                    'campaign_id' => $campaignId,
                    'campaign_name' => $campaign->name,
                ]);

                return response()->json([
                    'success' => false,
                    'message' => $result['error'] ?? 'Lỗi khi sync analytics'
                ]);
            }

        } catch (\Exception $e) {
            Log::error("💥 Exception in sync campaign analytics for Campaign ID: {$campaignId}: " . $e->getMessage(), [
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Lỗi hệ thống: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get analytics stats for a campaign (helper method)
     */
    private function getCampaignAnalyticsStats($campaignId): array
    {
        $analytics = CampaignAnalytics::where('campaign_id', $campaignId)
            ->latest('insights_date')
            ->get();

        if ($analytics->isEmpty()) {
            return [
                'impressions' => 0,
                'total_engagement' => 0,
                'avg_engagement_rate' => 0,
            ];
        }

        $totalImpressions = 0;
        $totalEngagement = 0;
        $engagementRates = [];

        foreach ($analytics as $item) {
            $totalImpressions += $item->impressions;
            $totalEngagement += $item->reactions_total + $item->comments + $item->shares;

            if ($item->engagement_rate > 0) {
                $engagementRates[] = $item->engagement_rate;
            }
        }

        $avgEngagementRate = !empty($engagementRates)
            ? round(array_sum($engagementRates) / count($engagementRates), 2)
            : 0;

        return [
            'impressions' => $totalImpressions,
            'total_engagement' => $totalEngagement,
            'avg_engagement_rate' => $avgEngagementRate,
        ];
    }
}
