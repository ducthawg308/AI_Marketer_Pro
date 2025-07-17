<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        if (in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }

        abort(403, 'Bạn không có quyền truy cập.');
    }
}

