<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;
use Illuminate\Routing\Attributes\Middleware;

Route::get('/', function () {
    return view('home');
})->name('home');

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

    Route::resource('audience_config', App\Http\Controllers\Dashboard\AudienceConfig\AudienceConfigController::class)->except(['show']);

    Route::resource('content_creator', App\Http\Controllers\Dashboard\ContentCreator\ContentCreatorController::class)->except(['create','show']);
    Route::prefix('content_creator')->name('content_creator.')->group(function () {
        Route::get('product', [App\Http\Controllers\Dashboard\ContentCreator\ContentCreatorController::class, 'createFromProduct'])->name('product');
        Route::get('link', [App\Http\Controllers\Dashboard\ContentCreator\ContentCreatorController::class, 'createFromLink'])->name('link');
        Route::get('manual', [App\Http\Controllers\Dashboard\ContentCreator\ContentCreatorController::class, 'createFromManual'])->name('manual');
        Route::put('update-setting', [App\Http\Controllers\Dashboard\ContentCreator\ContentCreatorController::class, 'updateSetting'])->name('update-setting');
    });

    Route::resource('auto_publisher', App\Http\Controllers\Dashboard\AutoPublisher\ScheduleController::class)->except(['show','edit']);
    
    Route::resource('auto_publisher/campaign', App\Http\Controllers\Dashboard\AutoPublisher\CampaignController::class)->except(['show','create']);
    Route::prefix('auto_publisher/campaign')->name('auto_publisher.campaign.')->group(function () {
        Route::post('preview', [App\Http\Controllers\Dashboard\AutoPublisher\CampaignController::class, 'preview'])->name('preview');
    });

    Route::resource('market_analysis', App\Http\Controllers\Dashboard\MarketAnalysis\MarketAnalysisController::class);
    Route::prefix('market_analysis')->name('market_analysis.')->group(function () {
        Route::post('analyze', [App\Http\Controllers\Dashboard\MarketAnalysis\MarketAnalysisController::class, 'analyze'])->name('analyze');
    });
    
    Route::get('/campaign_tracking', function () {
        return view('dashboard.campaign_tracking.index');
    })->name('campaign_tracking.index');
});

require __DIR__.'/auth.php';
