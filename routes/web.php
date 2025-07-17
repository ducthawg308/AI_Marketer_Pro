<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;
use Illuminate\Routing\Attributes\Middleware;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/admin', function () {
    return 'Trang quản trị - Admin';
})->middleware(['auth', CheckRole::class . ':admin']);

Route::get('/user', function () {
    return 'Trang người dùng';
})->middleware(['auth', CheckRole::class . ':user']);

Route::get('/role-dashboard', function () {
    return 'Dashboard riêng phân quyền (admin/user đều vào được)';
})->middleware(['auth', CheckRole::class . ':admin,user']);

require __DIR__.'/auth.php';
