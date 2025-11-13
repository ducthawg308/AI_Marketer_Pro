<?php

namespace App\Models\Dashboard\AutoPublisher;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $table = 'campaigns';

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'start_date',
        'end_date',
        'frequency',
        'status',
    ];

    public function schedules()
    {
        return $this->hasMany(AdSchedule::class, 'campaign_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
