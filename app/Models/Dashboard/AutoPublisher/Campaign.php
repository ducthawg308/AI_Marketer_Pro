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
        'platforms',
        'frequency_type',
        'default_time_start',
        'default_time_end',
        'frequency_config',
        'status',
        'launched_at',
        'completed_at',
    ];

    protected $casts = [
        'platforms'       => 'array',
        'frequency_config'=> 'array',
        'start_date'      => 'datetime',
        'end_date'        => 'datetime',
        'launched_at'     => 'datetime',
        'completed_at'    => 'datetime',
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

    // Accessor for frequency (alias for frequency_type)
    public function getFrequencyAttribute()
    {
        return $this->frequency_type;
    }

    public function setFrequencyAttribute($value)
    {
        $this->frequency_type = $value;
    }

    /**
     * Get posts_per_day from frequency_config JSON
     */
    public function getPostsPerDayAttribute(): int
    {
        return $this->frequency_config['posts_per_day'] ?? 1;
    }

    /**
     * Get estimated total posts for this campaign
     */
    public function getEstimatedTotalPosts(): int
    {
        $config = $this->frequency_config ?? [];

        switch ($this->frequency_type) {
            case 'daily':
                $days = $this->end_date
                    ? $this->start_date->diffInDays($this->end_date) + 1
                    : 30;
                return ($config['posts_per_day'] ?? 1) * $days;

            case 'weekly':
                $selectedDays = $config['selected_days'] ?? [1];
                $postsPerWeek = count($selectedDays) * ($config['posts_per_week'] ?? 1);
                $weeks = $this->end_date
                    ? ceil($this->start_date->diffInDays($this->end_date) / 7)
                    : 4;
                return $postsPerWeek * $weeks;

            case 'custom':
                $dayConfig = $config['days'] ?? [];
                $weekTotal = array_sum($dayConfig);
                $weeks = $this->end_date
                    ? ceil($this->start_date->diffInDays($this->end_date) / 7)
                    : 4;
                return $weekTotal * $weeks;

            default:
                return 1;
        }
    }

    public function getTotalPostsCountAttribute(): int
    {
        return $this->getEstimatedTotalPosts();
    }

    public function pages()
    {
        if (!$this->platforms) {
            return collect();
        }

        return UserPage::where('user_id', $this->user_id)
            ->whereIn('id', $this->platforms)
            ->get();
    }
}
