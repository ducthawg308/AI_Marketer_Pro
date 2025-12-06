<?php

namespace App\Repositories\Interfaces\Dashboard\CampaignTracking;

interface CampaignTrackingInterface
{
    /**
     * Save or update detailed analytics data
     */
    public function saveAnalyticsData($adSchedule, $surfaceData): array;

    /**
     * Get analytics stats for a campaign with reaction breakdown
     */
    public function getCampaignAnalyticsStats($campaignId): array;
}
