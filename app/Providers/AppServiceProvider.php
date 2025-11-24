<?php

namespace App\Providers;

use App\Services\Dashboard\MarketAnalysis\PredictiveAnalyticsService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PredictiveAnalyticsService::class, function ($app) {
            return new PredictiveAnalyticsService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
