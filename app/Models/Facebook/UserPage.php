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
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
