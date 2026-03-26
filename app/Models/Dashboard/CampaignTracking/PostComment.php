<?php

namespace App\Models\Dashboard\CampaignTracking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PostComment extends Model
{
    use HasFactory;

    protected $table = 'post_comments';

    protected $fillable = [
        'campaign_analytics_id',
        'facebook_comment_id',
        'parent_comment_id',
        'message',
        'from_facebook_id',
        'from_name',
        'like_count',
        'comment_created_at',
    ];

    protected $casts = [
        'comment_created_at' => 'datetime',
    ];

    public function campaignAnalytics(): BelongsTo
    {
        return $this->belongsTo(CampaignAnalytics::class, 'campaign_analytics_id');
    }

    public function aiAnalysis(): HasOne
    {
        return $this->hasOne(CommentAiAnalysis::class, 'post_comment_id');
    }

    public function autoReply()
    {
        return $this->hasOneThrough(
            CommentAutoReply::class,
            CommentAiAnalysis::class,
            'post_comment_id',         // FK on comment_ai_analysis
            'comment_ai_analysis_id',  // FK on comment_auto_replies
            'id',                      // local key on post_comments
            'id'                       // local key on comment_ai_analysis
        );
    }

    /**
     * Get parent comment if this is a reply
     */
    public function parentComment(): BelongsTo
    {
        return $this->belongsTo(PostComment::class, 'parent_comment_id', 'facebook_comment_id');
    }
}
