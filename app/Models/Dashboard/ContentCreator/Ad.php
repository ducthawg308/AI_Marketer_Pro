<?php

namespace App\Models\Dashboard\ContentCreator;

use App\Models\Dashboard\AudienceConfig\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ad extends Model
{
    use HasFactory;

    protected $table = 'ads';

    protected $fillable = [
        'user_id',
        'product_id',
        'video_id',
        'type',
        'media_type',
        'link',
        'ad_title',
        'ad_content',
        'hashtags',
        'emojis',
        'status',
    ];

    protected $casts = [
        'hashtags' => 'array',
        'emojis'   => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function adImages(): HasMany
    {
        return $this->hasMany(AdImage::class);
    }

    public function video(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Dashboard\ContentCreator\Video::class, 'video_id');
    }

    /**
     * Get hashtags as formatted string for display (#tag1 #tag2)
     */
    public function getHashtagsStringAttribute(): string
    {
        if (empty($this->hashtags)) {
            return '';
        }
        return implode(' ', array_map(
            fn($tag) => str_starts_with($tag, '#') ? $tag : '#' . $tag,
            $this->hashtags
        ));
    }
}
