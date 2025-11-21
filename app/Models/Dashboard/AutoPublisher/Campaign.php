<?php

namespace App\Models\Dashboard\AutoPublisher;

use App\Models\User;
use App\Models\Facebook\UserPage;
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
        'objective',
        'start_date',
        'end_date',
        'frequency_type',
        'posts_per_day',
        'weekday_frequency',
        'saturday_frequency',
        'sunday_frequency',
        'platforms',
        'default_time_start',
        'default_time_end',
        'frequency_config',
        'status',
        'launched_at',
        'completed_at',
    ];

    protected $casts = [
        'platforms' => 'array',
        'frequency_config' => 'array',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'launched_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function schedules()
    {
        return $this->hasMany(AdSchedule::class, 'campaign_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getSelectedPages()
    {
        if (!$this->platforms) {
            return collect();
        }

        return UserPage::where('user_id', $this->user_id)
            ->whereIn('id', $this->platforms)
            ->get();
    }

    // Accessor for frequency (use frequency_type column)
    public function getFrequencyAttribute()
    {
        return $this->frequency_type;
    }

    // Mutator for frequency
    public function setFrequencyAttribute($value)
    {
        $this->frequency_type = $value;
    }

    // Get total posts estimation
    public function getEstimatedTotalPosts()
    {
        switch ($this->frequency_type) {
            case 'daily':
                $days = $this->end_date ? $this->start_date->diffInDays($this->end_date) + 1 : 30;
                return $this->posts_per_day * $days;
            case 'weekly':
                // Assuming 1 post per week on selected days
                return max($this->weekday_frequency + $this->saturday_frequency + $this->sunday_frequency, 1);
            default:
                return 1;
        }
    }
}
