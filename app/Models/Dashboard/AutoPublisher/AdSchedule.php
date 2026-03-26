<?php

namespace App\Models\Dashboard\AutoPublisher;

use App\Models\User;
use App\Models\Dashboard\ContentCreator\Ad;
use App\Models\Facebook\UserPage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdSchedule extends Model
{
    use HasFactory;

    protected $table = 'ad_schedule';

    protected $fillable = [
        'user_id',
        'ad_id',
        'campaign_id',
        'user_page_id',
        'scheduled_time',
        'status',
        'facebook_post_id',
    ];

    protected $casts = [
        'scheduled_time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ad()
    {
        return $this->belongsTo(Ad::class, 'ad_id');
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }

    public function userPage()
    {
        return $this->belongsTo(UserPage::class, 'user_page_id');
    }

    public function analytics()
    {
        return $this->hasMany(\App\Models\Dashboard\CampaignTracking\CampaignAnalytics::class, 'ad_schedule_id');
    }

    public function latestAnalytics()
    {
        return $this->hasOne(\App\Models\Dashboard\CampaignTracking\CampaignAnalytics::class, 'ad_schedule_id')
                    ->latestOfMany('insights_date');
    }
}
