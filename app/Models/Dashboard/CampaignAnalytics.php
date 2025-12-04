<?php

namespace App\Models\Dashboard;

use App\Models\Dashboard\AutoPublisher\AdSchedule;
use App\Models\Dashboard\AutoPublisher\Campaign;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CampaignAnalytics extends Model
{
    use HasFactory;

    protected $table = 'campaign_analytics';

    protected $fillable = [
        'campaign_id',
        'ad_schedule_id',
        'facebook_post_id',
        'impressions',
        'reach',
        'clicks',
        'engaged_users',
        'negative_feedback',
        'reactions_total',
        'reactions_like',
        'reactions_love',
        'reactions_wow',
        'reactions_haha',
        'reactions_sorry',
        'reactions_anger',
        'comments',
        'shares',
        'video_views',
        'video_view_time_organic',
        'video_views_3s',
        'video_completions',
        'post_message',
        'post_created_time',
        'post_permalink_url',
        'engagement_rate',
        'click_through_rate',
        'raw_insights',
        'fetched_at',
        'insights_date',
    ];

    protected $casts = [
        'raw_insights' => 'array',
        'fetched_at' => 'datetime',
        'insights_date' => 'date',
        'post_created_time' => 'datetime',
        'engagement_rate' => 'decimal:2',
        'click_through_rate' => 'decimal:2',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }

    public function adSchedule()
    {
        return $this->belongsTo(AdSchedule::class, 'ad_schedule_id');
    }

    /**
     * Update engagement rate tính từ reactions + comments + shares
     */
    public function updateEngagementRate()
    {
        if ($this->impressions > 0) {
            $total_engagement = $this->reactions_total + $this->comments + $this->shares;
            $this->engagement_rate = round(($total_engagement / $this->impressions) * 100, 2);
        } else {
            $this->engagement_rate = 0;
        }
    }

    /**
     * Update click through rate
     */
    public function updateClickThroughRate()
    {
        if ($this->impressions > 0) {
            $this->click_through_rate = round(($this->clicks / $this->impressions) * 100, 2);
        } else {
            $this->click_through_rate = 0;
        }
    }
}
