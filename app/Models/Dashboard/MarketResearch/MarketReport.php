<?php

namespace App\Models\Dashboard\MarketResearch;

use App\Models\Dashboard\AudienceConfig\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MarketReport extends Model
{
    use HasFactory;

    protected $table = 'market_reports';

    protected $fillable = [
        'product_id',
        'user_id',
        'status',
        'current_step',
        'progress_percent',
        'error_message',
        'raw_data',
        'quantitative_analysis',
        'qualitative_analysis',
        'chart_data',
        'data_collected_at',
        'analysis_completed_at',
        'completed_at',
    ];

    protected $casts = [
        'raw_data' => 'array',
        'quantitative_analysis' => 'array',
        'qualitative_analysis' => 'array',
        'chart_data' => 'array',
        'data_collected_at' => 'datetime',
        'analysis_completed_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
