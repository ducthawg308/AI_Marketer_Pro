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
        'token_expires_at',
        'category',
        'about',
        'link',
        'fan_count',
        'is_published',
        'avatar_url',
    ];

    protected $casts = [
        'token_expires_at' => 'datetime',
        'is_published'     => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Check if the page access token is still valid
     */
    public function isTokenValid(): bool
    {
        if (!$this->token_expires_at) {
            // No expiry set — assume valid (long-lived page tokens often have no expiry)
            return !empty($this->page_access_token);
        }

        return $this->token_expires_at->isFuture();
    }

    /**
     * Check if token expires within given days
     */
    public function isTokenExpiringSoon(int $days = 7): bool
    {
        if (!$this->token_expires_at) {
            return false;
        }

        return $this->token_expires_at->isBefore(now()->addDays($days));
    }
}
