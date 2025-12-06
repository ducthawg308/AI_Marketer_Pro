<?php

namespace App\Http\Controllers\Dashboard\CampaignTracking;

use App\Http\Controllers\Controller;
use App\Models\Dashboard\AutoPublisher\Campaign;
use App\Repositories\Interfaces\Dashboard\CampaignTracking\CampaignTrackingInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CampaignTrackingController extends Controller
{
    public function __construct(private CampaignTrackingInterface $campaignTrackingRepository) {}

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

        // Tổng hợp stats cho campaign (raw surface metrics)
        $totalStats = [
            'total_posts' => $schedules->count(),
            'total_reactions' => 0,
            'total_comments' => 0,
            'total_shares' => 0,
        ];

        foreach ($schedules as $schedule) {
            if ($schedule->analytics && $schedule->analytics->isNotEmpty()) {
                $analytics = $schedule->analytics->first();
                $totalStats['total_reactions'] += $analytics->reactions_total;
                $totalStats['total_comments'] += $analytics->comments;
                $totalStats['total_shares'] += $analytics->shares;
            }
        }

        return view('dashboard.campaign_tracking.show', compact('campaign', 'schedules', 'totalStats'));
    }




    /**
     * Sync analytics cho một campaign
     */
    public function sync($campaignId)
    {
        try {
            $userId = Auth::id();

            // Verify campaign belongs to user
            $campaign = Campaign::where('user_id', $userId)->findOrFail($campaignId);

            // Sync analytics
            $result = app(\App\Services\Dashboard\CampaignTracking\CampaignTrackingService::class)->syncCampaignAnalytics([$campaignId]);

            if ($result['success']) {
                if (!empty($result['errors'])) {
                    Log::warning("Sync completed with errors for some posts:", $result['errors']);
                }

                return back()->with('toast-success', "Đã sync analytics thành công cho {$result['posts_processed']} posts");
            } else {
                return back()->with('toast-error', $result['error'] ?? 'Lỗi khi sync analytics');
            }

        } catch (\Exception $e) {
            Log::error("💥 Exception in sync campaign analytics for Campaign ID: {$campaignId}: " . $e->getMessage(), [
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('toast-error', 'Lỗi hệ thống: ' . $e->getMessage());
        }
    }

    /**
     * Get analytics stats for a campaign (helper method) - use repository
     */
    private function getCampaignAnalyticsStats($campaignId): array
    {
        return $this->campaignTrackingRepository->getCampaignAnalyticsStats($campaignId);
    }
}
