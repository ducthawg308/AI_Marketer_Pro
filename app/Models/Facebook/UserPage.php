<?php

namespace App\Models\Facebook;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPage extends Model
{
    use HasFactory;

    protected $table = 'user_pages';

    protected $fillable = [
        'user_id',
        'page_id',
        'page_name',
        'page_access_token',
        'category',
        'about',
        'link',
        'fan_count',
        'is_published',
        'picture_url',
        'source_type',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'fan_count' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Kiểm tra page có phải từ Business Manager không
     */
    public function isFromBusinessManager(): bool
    {
        return $this->source_type === 'business_manager';
    }

    /**
     * Kiểm tra page có phải user sở hữu trực tiếp không
     */
    public function isOwnedPage(): bool
    {
        return $this->source_type === 'owned';
    }

    /**
     * Lấy avatar URL với size tùy chỉnh
     */
    public function getAvatarUrl(int $width = 200, int $height = 200): ?string
    {
        if (!$this->picture_url) {
            return null;
        }

        // Facebook picture URL có thể thêm params để resize
        return $this->picture_url . "?width={$width}&height={$height}";
    }
}
