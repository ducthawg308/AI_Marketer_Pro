<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\Dashboard\AudienceConfigRepository;
use App\Repositories\Eloquent\Dashboard\AutoPublisherRepository;
use App\Repositories\Eloquent\Dashboard\ContentCreatorRepository;
use App\Repositories\Interfaces\Dashboard\AudienceConfigInterface;
use App\Repositories\Interfaces\Dashboard\AutoPublisherInterface;
use App\Repositories\Interfaces\Dashboard\ContentCreatorInterface;
use Illuminate\Mail\Mailables\Content;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AudienceConfigInterface::class, AudienceConfigRepository::class);
        $this->app->bind(ContentCreatorInterface::class, ContentCreatorRepository::class);
        $this->app->bind(AutoPublisherInterface::class, AutoPublisherRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
