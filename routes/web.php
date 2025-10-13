<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'check.route.permission'])->group(function () {
    // Role Guest ---------------------------------------------------------
    Route::get('/', function () {
        return view('home');
    })->name('home');

    // Admin Routes --------------------------------------------------------
    Route::group(['as' => 'admin.', 'prefix' => 'admin'], function () {
        Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('index');

        Route::resource('users', App\Http\Controllers\Admin\Users\UsersController::class)->except(['show']);
        Route::resource('roles', \App\Http\Controllers\Admin\Roles\RolesController::class);
        Route::resource('permissions', \App\Http\Controllers\Admin\Permissions\PermissionsController::class);
    });

    // Profile Routes -------------------------------------------------
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard Routes ---------------------------------------------------------
    Route::group(['as' => 'dashboard.', 'prefix' => 'dashboard'], function () {
        Route::get('/', [App\Http\Controllers\Dashboard\DashboardController::class, 'index'])->name('index');

        // Audience Config
        Route::resource('audience_config', App\Http\Controllers\Dashboard\AudienceConfig\AudienceConfigController::class)->except(['show']);

        // Content Creator
        Route::prefix('content_creator')->name('content_creator.')->group(function () {
            Route::get('product', [App\Http\Controllers\Dashboard\ContentCreator\ContentCreatorController::class, 'createFromProduct'])->name('product');
            Route::get('link', [App\Http\Controllers\Dashboard\ContentCreator\ContentCreatorController::class, 'createFromLink'])->name('link');
            Route::get('manual', [App\Http\Controllers\Dashboard\ContentCreator\ContentCreatorController::class, 'createFromManual'])->name('manual');
            Route::patch('update-setting', [App\Http\Controllers\Dashboard\ContentCreator\ContentCreatorController::class, 'updateSetting'])->name('update-setting');
        });
        Route::resource('content_creator', App\Http\Controllers\Dashboard\ContentCreator\ContentCreatorController::class)->except(['create', 'show']);

        // Auto Publisher
        Route::prefix('auto_publisher/campaign')->name('auto_publisher.campaign.')->group(function () {
            Route::post('roadmap', [App\Http\Controllers\Dashboard\AutoPublisher\CampaignController::class, 'roadmap'])->name('roadmap');
        });
        Route::resource('auto_publisher', App\Http\Controllers\Dashboard\AutoPublisher\ScheduleController::class)->except(['show','edit']);
        Route::resource('auto_publisher/campaign', App\Http\Controllers\Dashboard\AutoPublisher\CampaignController::class)->except(['show','create']);
        
        // Market Analysis
        Route::prefix('market_analysis')->name('market_analysis.')->group(function () {
            Route::post('analyze', [App\Http\Controllers\Dashboard\MarketAnalysis\MarketAnalysisController::class, 'analyze'])->name('analyze');
        });
        Route::resource('market_analysis', App\Http\Controllers\Dashboard\MarketAnalysis\MarketAnalysisController::class);
        
        //Campaign Tracking
        Route::get('/campaign_tracking', function () {
            return view('dashboard.campaign_tracking.index');
        })->name('campaign_tracking.index');
    });
});

require __DIR__.'/auth.php';