<?php

namespace App\Models\Dashboard\AudienceConfig;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TargetCustomer extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'age_range',
        'income_level',
        'interests',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}