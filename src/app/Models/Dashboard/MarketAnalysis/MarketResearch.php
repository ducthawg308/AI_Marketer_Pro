<?php

namespace App\Models\Dashboard\MarketAnalysis;

use App\Models\Dashboard\AudienceConfig\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MarketResearch extends Model
{
    use HasFactory;

    protected $table = 'market_researches';

    protected $fillable = [
        'user_id',
        'product_id',
        'research_type',
        'start_date',
        'end_date',
        'status',
        'report_file',
        'analysis_data',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
