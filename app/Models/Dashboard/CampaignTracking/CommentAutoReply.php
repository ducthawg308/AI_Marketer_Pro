<?php

namespace App\Models\Dashboard\CampaignTracking;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommentAutoReply extends Model
{
    use HasFactory;

    protected $table = 'comment_auto_replies';

    protected $fillable = [
        'comment_id',
        'reply_text',
        'status',
        'retry_count',
        'response_fb',
    ];

    protected $casts = [
        'retry_count' => 'integer',
        'response_fb' => 'array',
    ];

    public function commentAiAnalysis()
    {
        return $this->belongsTo(CommentAiAnalysis::class, 'comment_id', 'comment_id');
    }
}