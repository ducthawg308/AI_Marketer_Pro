<?php

namespace App\Models\Dashboard\ContentCreator;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'original_filename',
        'original_path',
        'edited_path',
        'thumbnail_path',
        'duration',
        'width',
        'height',
        'file_size',
        'format',
        'codec',
        'status',
        'edit_history',
    ];

    protected $casts = [
        'edit_history' => 'array',
    ];

    protected $appends = [
        'original_url',
        'edited_url',
        'thumbnail_url',
        'formatted_duration',
        'formatted_file_size',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getOriginalUrlAttribute(): string
    {
        return asset('storage/' . $this->original_path);
    }

    public function getEditedUrlAttribute(): ?string
    {
        return $this->edited_path ? asset('storage/' . $this->edited_path) : null;
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->thumbnail_path ? asset('storage/' . $this->thumbnail_path) : null;
    }

    public function getFormattedDurationAttribute(): ?string
    {
        if (!$this->duration) {
            return null;
        }

        $hours = floor($this->duration / 3600);
        $minutes = floor(($this->duration % 3600) / 60);
        $seconds = $this->duration % 60;

        if ($hours > 0) {
            return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
        }

        return sprintf('%02d:%02d', $minutes, $seconds);
    }

    public function getFormattedFileSizeAttribute(): ?string
    {
        if (!$this->file_size) {
            return null;
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->file_size;
        $unit = 0;

        while ($size >= 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }

        return round($size, 2) . ' ' . $units[$unit];
    }
}
