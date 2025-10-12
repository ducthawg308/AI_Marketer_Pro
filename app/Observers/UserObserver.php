<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Dashboard\ContentCreator\AiSetting;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    public function created(User $user): void
    {
        if (!$user->hasAnyRole()) {
            try {
                $role = Role::where('name', 'user')->first();
                if ($role) {
                    $user->assignRole($role);
                } else {
                    Log::warning("Role 'user' not found for user {$user->id}");
                }
            } catch (\Exception $e) {
                Log::error("Failed to assign role: {$e->getMessage()}");
            }
        }

        if (!AiSetting::where('user_id', $user->id)->exists()) {
            try {
                AiSetting::create([
                    'user_id'  => $user->id,
                    'tone'     => config('ai.default_tone', 'friendly'),
                    'length'   => config('ai.default_length', 'medium'),
                    'platform' => config('ai.default_platform', 'Facebook'),
                    'language' => config('ai.default_language', 'Vietnamese'),
                ]);
            } catch (\Exception $e) {
                Log::error("Failed to create AI settings: {$e->getMessage()}");
            }
        }
    }
}