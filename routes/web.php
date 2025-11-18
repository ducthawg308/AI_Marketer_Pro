<?php

use App\Http\Controllers\ProfileController;
use Cloudinary\Cloudinary;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
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
            Route::get('edit_image', [App\Http\Controllers\Dashboard\ContentCreator\ContentCreatorController::class, 'editImage'])->name('image');
            Route::get('edit_video', [App\Http\Controllers\Dashboard\ContentCreator\ContentCreatorController::class, 'editVideo'])->name('video');
            Route::get('remove_bg', [App\Http\Controllers\Dashboard\ContentCreator\ContentCreatorController::class, 'removeBg'])->name('bg');
            Route::patch('update-setting', [App\Http\Controllers\Dashboard\ContentCreator\ContentCreatorController::class, 'updateSetting'])->name('update-setting');

            // Background Removal Routes
            Route::get('remove-background', [App\Http\Controllers\Dashboard\ContentCreator\BackgroundRemovalController::class, 'index'])->name('remove_background.index');
            Route::post('remove-background', [App\Http\Controllers\Dashboard\ContentCreator\BackgroundRemovalController::class, 'remove'])->name('remove_background.remove');
            Route::get('download/{filename}', [App\Http\Controllers\Dashboard\ContentCreator\BackgroundRemovalController::class, 'download'])->name('remove_background.download');

            // Video API endpoints
            Route::prefix('videos')->name('videos.')->group(function () {
                Route::get('/', [App\Http\Controllers\Dashboard\ContentCreator\VideoController::class, 'index'])->name('index');
                Route::post('/', [App\Http\Controllers\Dashboard\ContentCreator\VideoController::class, 'upload'])->name('upload');
                Route::get('/{id}', [App\Http\Controllers\Dashboard\ContentCreator\VideoController::class, 'show'])->name('show');
                Route::post('/{id}/trim', [App\Http\Controllers\Dashboard\ContentCreator\VideoController::class, 'trim'])->name('trim');
                Route::post('/{id}/text', [App\Http\Controllers\Dashboard\ContentCreator\VideoController::class, 'addText'])->name('text');
                Route::post('/merge', [App\Http\Controllers\Dashboard\ContentCreator\VideoController::class, 'merge'])->name('merge');
                Route::post('/{id}/filter', [App\Http\Controllers\Dashboard\ContentCreator\VideoController::class, 'applyFilter'])->name('filter');
                Route::post('/{id}/resize', [App\Http\Controllers\Dashboard\ContentCreator\VideoController::class, 'resize'])->name('resize');
                Route::post('/{id}/rotate', [App\Http\Controllers\Dashboard\ContentCreator\VideoController::class, 'rotate'])->name('rotate');
                Route::post('/{id}/speed', [App\Http\Controllers\Dashboard\ContentCreator\VideoController::class, 'adjustSpeed'])->name('speed');
                Route::post('/{id}/audio', [App\Http\Controllers\Dashboard\ContentCreator\VideoController::class, 'addAudio'])->name('audio');
                Route::get('/{id}/extract-audio', [App\Http\Controllers\Dashboard\ContentCreator\VideoController::class, 'extractAudio'])->name('extract-audio');
                Route::get('/{id}/download', [App\Http\Controllers\Dashboard\ContentCreator\VideoController::class, 'download'])->name('download');
                Route::delete('/{id}', [App\Http\Controllers\Dashboard\ContentCreator\VideoController::class, 'destroy'])->name('destroy');
            });
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
            Route::get('export/{type}', [App\Http\Controllers\Dashboard\MarketAnalysis\MarketAnalysisController::class, 'export'])->name('export');
        });
        Route::resource('market_analysis', App\Http\Controllers\Dashboard\MarketAnalysis\MarketAnalysisController::class);
        
        //Campaign Tracking
        Route::get('/campaign_tracking', function () {
            return view('dashboard.campaign_tracking.index');
        })->name('campaign_tracking.index');
    });
});

require __DIR__.'/auth.php';
