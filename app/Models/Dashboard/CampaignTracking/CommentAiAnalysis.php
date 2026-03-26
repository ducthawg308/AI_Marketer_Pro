<?php

namespace App\Models\Dashboard\CampaignTracking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CommentAiAnalysis extends Model
{
    use HasFactory;

    protected $table = 'comment_ai_analysis';

    protected $fillable = [
        'post_comment_id',
        'facebook_comment_id',
        'message',
        'sentiment',
        'type',
        'should_reply',
        'priority',
        'confidence',
    ];

    protected $casts = [
        'should_reply' => 'boolean',
        'confidence'   => 'float',
    ];

    public function postComment(): BelongsTo
    {
        return $this->belongsTo(PostComment::class, 'post_comment_id');
    }

    public function autoReply(): HasOne
    {
        return $this->hasOne(CommentAutoReply::class, 'comment_ai_analysis_id');
    }

    /**
     * Convenience: get the campaign analytics through post_comment
     */
    public function campaignAnalytics()
    {
        return $this->postComment?->campaignAnalytics;
    }
}