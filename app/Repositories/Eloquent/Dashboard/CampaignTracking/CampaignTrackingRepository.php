<?php

namespace App\Repositories\Eloquent\Dashboard\CampaignTracking;

use App\Models\Dashboard\CampaignTracking\CampaignAnalytics;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Dashboard\CampaignTracking\CampaignTrackingInterface;
use Illuminate\Support\Facades\Log;

class CampaignTrackingRepository extends BaseRepository implements CampaignTrackingInterface
{
    public function getModel(): string
    {
        return CampaignAnalytics::class;
    }

    /**
     * Save or update detailed analytics data
     */
    public function saveAnalyticsData($adSchedule, $surfaceData): array
    {
        try {
            $campaignId = $adSchedule->campaign_id;
            $today = now()->toDateString();

            // Find existing analytics record or create new
            $analytics = $this->model->firstOrNew([
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
            Log::error("Exception in CampaignTrackingRepository::saveAnalyticsData: " . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Get analytics stats for a campaign with reaction breakdown
     */
    public function getCampaignAnalyticsStats($campaignId): array
    {
        $analytics = $this->model->where('campaign_id', $campaignId)
            ->latest('insights_date')
            ->get();

        if ($analytics->isEmpty()) {
            return [
                'total_posts' => 0,
                // Reactions summary
                'total_reactions' => 0,
                'reactions_breakdown' => [
                    'like' => 0,
                    'love' => 0,
                    'wow' => 0,
                    'haha' => 0,
                    'sorry' => 0,
                    'anger' => 0,
                ],
                // Comments & Shares
                'total_comments' => 0,
                'total_shares' => 0,
            ];
        }

        $totalReactions = 0;
        $totalComments = 0;
        $totalShares = 0;
        $reactionBreakdown = [
            'like' => 0,
            'love' => 0,
            'wow' => 0,
            'haha' => 0,
            'sorry' => 0,
            'anger' => 0,
        ];

        foreach ($analytics as $item) {
            $totalReactions += $item->reactions_total;
            $totalComments += $item->comments;
            $totalShares += $item->shares;

            // Accumulate reaction breakdown
            $reactionBreakdown['like'] += $item->reactions_like;
            $reactionBreakdown['love'] += $item->reactions_love;
            $reactionBreakdown['wow'] += $item->reactions_wow;
            $reactionBreakdown['haha'] += $item->reactions_haha;
            $reactionBreakdown['sorry'] += $item->reactions_sorry;
            $reactionBreakdown['anger'] += $item->reactions_anger;
        }

        return [
            'total_posts' => $analytics->count(),
            'total_reactions' => $totalReactions,
            'reactions_breakdown' => $reactionBreakdown,
            'total_comments' => $totalComments,
            'total_shares' => $totalShares,
        ];
    }
}
