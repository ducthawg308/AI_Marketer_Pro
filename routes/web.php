<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;
use Illuminate\Routing\Attributes\Middleware;

Route::get('/', function () {
    return view('home');
})->name('home');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

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

Route::group(['as' => 'dashboard.','prefix' => 'dashboard','middleware' => ['auth', 'verified', CheckRole::class . ':admin,user']], function () {
    Route::get('/', [App\Http\Controllers\Dashboard\DashboardController::class, 'index'])->name('index');
    
    Route::resource('audienceconfig', App\Http\Controllers\Dashboard\AudienceConfigController::class)
        ->except(['show']);

    Route::resource('aicreator', App\Http\Controllers\Dashboard\AiCreatorController::class)
        ->except(['create','show']);
    Route::put('dashboard/ai-creator/update-setting', [App\Http\Controllers\Dashboard\AiCreatorController::class, 'updateSetting'])->name('aicreator.update-setting');

    Route::get('/autopublisher', function () {
        return view('dashboard.auto_publisher.index');
    })->name('autopublisher.index');
});

require __DIR__.'/auth.php';

use App\Http\Controllers\FacebookPostController;

Route::get('/fb-post', [FacebookPostController::class, 'postToPage']);
