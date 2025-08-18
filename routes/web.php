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

    Route::resource('audience_config', App\Http\Controllers\Dashboard\AudienceConfigController::class)
        ->except(['show']);

    Route::resource('content_creator', App\Http\Controllers\Dashboard\ContentCreatorController::class)
        ->except(['create','show']);
    Route::get('/content_creator/product', [App\Http\Controllers\Dashboard\ContentCreatorController::class, 'createFromProduct'])->name('content_creator.product');
    Route::put('/content_creator/update-setting', [App\Http\Controllers\Dashboard\ContentCreatorController::class, 'updateSetting'])->name('content_creator.update-setting');

    Route::get('/autopublisher', function () {
        return view('dashboard.auto_publisher.index');
    })->name('autopublisher.index');

    Route::get('/marketanalysis', function () {
        return view('dashboard.market_analysis.index');
    })->name('marketanalysis.index');
});

require __DIR__.'/auth.php';

Route::get('/fb-post', [App\Http\Controllers\FacebookPostController::class, 'postToPage']);
