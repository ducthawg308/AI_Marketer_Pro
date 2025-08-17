<?php

namespace App\Models;

use App\Models\Dashboard\AICreator\Ad;
use App\Models\Dashboard\AiCreator\AiSetting;
use App\Models\Dashboard\AudienceConfig\Product;
use App\Models\Facebook\UserPage;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'facebook_id',
        'facebook_access_token',
        'facebook_token_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'facebook_token_expires_at'=> 'datetime',
            'password' => 'hashed',
        ];
    }

    public function ads(): HasMany
    {
        return $this->hasMany(Ad::class, 'user_id', 'id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'user_id', 'id');
    }

    public function pages(): HasMany
    {
        return $this->hasMany(UserPage::class, 'user_id', 'id');
    }

    public function aiSettings()
    {
        return $this->hasOne(AiSetting::class);
    }
}
