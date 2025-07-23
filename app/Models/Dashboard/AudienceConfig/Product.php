<?php

namespace App\Models\Dashboard\AudienceConfig;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{   
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'industry',
        'description',
        'user_id',
        'target_customer_age_range',
        'target_customer_income_level',
        'target_customer_interests',
        'competitor_name',
        'competitor_url',
        'competitor_description',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}