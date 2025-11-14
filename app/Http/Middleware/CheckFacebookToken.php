<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckFacebookToken
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user || !$user->facebook_access_token) {
            return $next($request);
        }

        if ($this->isTokenExpiredOrExpiring($user)) {
            session()->flash('warning', 'Token Facebook của bạn đã hết hạn hoặc sắp hết hạn. Vui lòng đăng nhập lại để cập nhật.');

            // return redirect()->route('auth.facebook');
        }

        return $next($request);
    }

    private function isTokenExpiredOrExpiring($user): bool
    {
        if (!$user->facebook_token_expires_at) {
            return true;
        }

        if ($user->facebook_token_expires_at->isPast()) {
            return true;
        }

        if ($user->facebook_token_expires_at->isBefore(now()->addDays(7))) {
            return true;
        }

        return false;
    }
}
