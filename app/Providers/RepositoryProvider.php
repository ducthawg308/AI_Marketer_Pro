<?php

namespace App\Providers;

use App\Repositories\Eloquent\Dashboard\AudienceConfigRepository;
use App\Repositories\Interfaces\Dashboard\AudienceConfigInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AudienceConfigInterface::class, AudienceConfigRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}
