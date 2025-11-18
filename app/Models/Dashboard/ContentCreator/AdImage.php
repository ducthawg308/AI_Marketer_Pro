<?php

namespace App\Models\Dashboard\ContentCreator;

use Cloudinary\Cloudinary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdImage extends Model
{
    use HasFactory;

    protected $table = 'ad_images';

    protected $fillable = [
        'ad_id',
        'image_path',
    ];

    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }

    /**
     * Lấy URL public đầy đủ của ảnh từ Cloudinary
     * VD: https://res.cloudinary.com/cloud_name/image/upload/v1234567890/public_id.jpg
     */
    public function getImageUrlAttribute()
    {
        return $this->getCloudinaryUrl($this->image_path);
    }

    /**
     * Build Cloudinary URL using SDK
     */
    private function getCloudinaryUrl(string $publicId, array $transformations = []): string
    {
        try {
            if (!$publicId) {
                return '';
            }

            // Use Cloudinary SDK to generate secure URL
            $cloudinary = new Cloudinary();

            if (!empty($transformations)) {
                $url = $cloudinary->image($publicId)->secure(true);
                foreach ($transformations as $key => $value) {
                    $method = 'addValue';
                    if (method_exists($url, $key)) {
                        $url = $url->$key($value);
                    }
                }
                return $url->toUrl();
            } else {
                return $cloudinary->image($publicId)->secure(true)->toUrl();
            }

        } catch (\Exception $e) {
            return '';
        }
    }
}
