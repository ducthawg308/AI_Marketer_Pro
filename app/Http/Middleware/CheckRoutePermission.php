<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CheckRoutePermission
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        // Lấy tên route hiện tại
        $currentRouteName = Route::currentRouteName();
        
        // Bỏ qua các route công khai (login, register, home...)
        $publicRoutes = ['login', 'register', 'home', 'logout'];
        if (in_array($currentRouteName, $publicRoutes)) {
            return $next($request);
        }

        // Check xem user có permission cho route này không
        if ($user->can($currentRouteName)) {
            return $next($request);
        }

        // Nếu không có quyền
        abort(403, 'Bạn không có quyền truy cập trang này.');
    }
}