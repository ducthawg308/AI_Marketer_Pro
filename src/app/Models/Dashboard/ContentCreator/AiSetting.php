<?php

namespace App\Models\Dashboard\ContentCreator;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiSetting extends Model
{
    use HasFactory;

    protected $table = 'ai_settings';

    protected $fillable = [
        'user_id',
        'tone',
        'length',
        'platform',
        'language',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
