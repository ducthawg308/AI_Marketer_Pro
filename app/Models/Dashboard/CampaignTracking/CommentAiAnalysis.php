<?php

namespace App\Models\Dashboard\CampaignTracking;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommentAiAnalysis extends Model
{
    use HasFactory;

    protected $table = 'comment_ai_analysis';

    protected $fillable = [
        'comment_id',
        'message',
        'sentiment',
        'type',
        'should_reply',
        'priority',
        'confidence',
    ];

    protected $casts = [
        'should_reply' => 'boolean',
        'confidence' => 'decimal:2',
    ];

    public function campaignAnalytics()
    {
        return $this->belongsTo(CampaignAnalytics::class, 'comment_id', 'id');
    }
}