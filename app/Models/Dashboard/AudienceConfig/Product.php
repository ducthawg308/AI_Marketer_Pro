<?php

namespace App\Models\Dashboard\AudienceConfig;

use App\Models\Dashboard\ContentCreator\Ad;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Dashboard\MarketResearch\MarketReport;

class Product extends Model
{
  use HasFactory;

  protected $table = 'products';

  protected $fillable = [
    'user_id',
    'name',
    'industry',
    'description',
    'target_customer_age_range',
    'target_customer_income_level',
    'target_customer_interests',
    'competitors',
  ];

  protected $casts = [
    'competitors' => 'array',
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }

  public function ads(): HasMany
  {
    return $this->hasMany(Ad::class, 'product_id', 'id');
  }

  public function marketReport(): HasOne
  {
    return $this->hasOne(MarketReport::class, 'product_id', 'id');
  }

}