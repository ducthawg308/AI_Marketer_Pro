<?php

namespace App\Providers;

use App\Repositories\Eloquent\Dashboard\AiCreatorRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\Dashboard\AudienceConfigRepository;
use App\Repositories\Interfaces\Dashboard\AiCreatorInterface;
use App\Repositories\Interfaces\Dashboard\AudienceConfigInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AudienceConfigInterface::class, AudienceConfigRepository::class);
        $this->app->bind(AiCreatorInterface::class, AiCreatorRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
