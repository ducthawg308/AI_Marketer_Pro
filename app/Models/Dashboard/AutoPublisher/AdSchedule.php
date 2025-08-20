<?php

namespace App\Models\Dashboard\AutoPublisher;

use App\Models\Dashboard\ContentCreator\Ad;
use App\Models\Facebook\UserPage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdSchedule extends Model
{
    use HasFactory;

    protected $table = 'ad_schedule';

    protected $fillable = [
        'ad_id',
        'user_page_id',
        'scheduled_time',
        'status',
        'is_recurring',
        'recurrence_interval'
    ];

    public function ad()
    {
        return $this->belongsTo(Ad::class, 'ad_id');
    }

    public function userPage()
    {
        return $this->belongsTo(UserPage::class, 'user_page_id');
    }
}
