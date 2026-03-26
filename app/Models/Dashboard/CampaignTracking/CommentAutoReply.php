<?php

namespace App\Models\Dashboard\CampaignTracking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommentAutoReply extends Model
{
    use HasFactory;

    protected $table = 'comment_auto_replies';

    protected $fillable = [
        'comment_ai_analysis_id',
        'reply_text',
        'status',
        'retry_count',
        'response_fb',
    ];

    protected $casts = [
        'response_fb' => 'array',
    ];

    public function aiAnalysis(): BelongsTo
    {
        return $this->belongsTo(CommentAiAnalysis::class, 'comment_ai_analysis_id');
    }

    /**
     * Convenience: get the post comment through analysis
     */
    public function postComment()
    {
        return $this->aiAnalysis?->postComment;
    }
}