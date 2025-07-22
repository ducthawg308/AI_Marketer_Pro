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
    ];

    public function targetCustomers(): HasMany
    {
        return $this->hasMany(TargetCustomer::class);
    }

    public function competitors(): HasMany
    {
        return $this->hasMany(Competitor::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}