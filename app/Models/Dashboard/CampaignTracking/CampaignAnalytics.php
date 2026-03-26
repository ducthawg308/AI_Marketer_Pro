<?php

namespace App\Models\Dashboard\CampaignTracking;

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
        'reactions_total',
        'reactions_like',
        'reactions_love',
        'reactions_wow',
        'reactions_haha',
        'reactions_sorry',
        'reactions_anger',
        'comments',
        'shares',
        'status_type',
        'post_message',
        'post_created_time',
        'post_updated_time',
        'post_permalink_url',
        'fetched_at',
        'insights_date',
    ];

    protected $casts = [
        'fetched_at'        => 'datetime',
        'insights_date'     => 'date',
        'post_created_time' => 'datetime',
        'post_updated_time' => 'datetime',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }

    public function adSchedule()
    {
        return $this->belongsTo(AdSchedule::class, 'ad_schedule_id');
    }

    public function postComments()
    {
        return $this->hasMany(PostComment::class, 'campaign_analytics_id');
    }

    public function commentAiAnalysis()
    {
        return $this->hasManyThrough(
            CommentAiAnalysis::class,
            PostComment::class,
            'campaign_analytics_id', // FK on post_comments
            'post_comment_id',        // FK on comment_ai_analysis
            'id',                     // local key on campaign_analytics
            'id'                      // local key on post_comments
        );
    }

    /**
     * Convenience: get the facebook_post_id from ad_schedule
     */
    public function getFacebookPostIdAttribute(): ?string
    {
        return $this->adSchedule?->facebook_post_id;
    }

    /**
     * Get unanalyzed comments for AI processing
     */
    public function unanalyzedComments()
    {
        return $this->postComments()->doesntHave('aiAnalysis');
    }
}
