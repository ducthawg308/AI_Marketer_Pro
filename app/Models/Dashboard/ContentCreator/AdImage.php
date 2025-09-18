<?php

namespace App\Models\Dashboard\ContentCreator;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdImage extends Model
{
    use HasFactory;

    protected $table = 'ad_images';

    protected $fillable = [
        'ad_id',
        'image_path',
        'facebook_media_id',
    ];

    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }

    /**
     * Lấy URL public đầy đủ của ảnh
     * VD: https://domain.com/storage/ads/image.jpg
     */
    public function getImageUrlAttribute()
    {
        return url('storage/' . $this->image_path);
    }
}
