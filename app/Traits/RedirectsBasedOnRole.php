<?php

namespace App\Traits;

trait RedirectsBasedOnRole
{
    protected function redirectPath(): string
    {
        $user = auth()->user();

        if (!$user) {
            return route('login');
        }

        $role = $user->getRoleNames()->first();
        
        // Lấy từ config
        $redirects = config('role_redirects.redirects', []);
        $defaultRedirect = config('role_redirects.default', '/');

        return $redirects[$role] ?? $defaultRedirect;
    }
}