<?php

namespace App\Models\Dashboard\MarketAnalysis;

use App\Models\Dashboard\AudienceConfig\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MarketResearch extends Model
{
    use HasFactory;

    protected $table = 'market_researches';

    protected $fillable = [
        'product_id',
        'research_type',
        'start_date',
        'end_date',
        'status',
        'report_file',
        'analysis_data',
        'title',
        'summary',
        'analysis_prompt',
    ];

    protected $casts = [
        'analysis_data'   => 'array',
        'analysis_prompt' => 'array',
        'start_date'      => 'date',
        'end_date'        => 'date',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    /**
     * Convenience: get the owning user through product
     */
    public function user()
    {
        return $this->product?->user;
    }
}
