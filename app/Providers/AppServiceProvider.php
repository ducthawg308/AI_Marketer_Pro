<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\Dashboard\AudienceConfig\AudienceConfigRepository;
use App\Repositories\Eloquent\Dashboard\AutoPublisher\ScheduleRepository;
use App\Repositories\Eloquent\Dashboard\AutoPublisher\CampaignRepository;
use App\Repositories\Eloquent\Dashboard\ContentCreator\ContentCreatorRepository;
use App\Repositories\Interfaces\Dashboard\AudienceConfig\AudienceConfigInterface;
use App\Repositories\Interfaces\Dashboard\AutoPublisher\ScheduleInterface;
use App\Repositories\Interfaces\Dashboard\AutoPublisher\CampaignInterface;
use App\Repositories\Interfaces\Dashboard\ContentCreator\ContentCreatorInterface;
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
        $this->app->bind(ScheduleInterface::class, ScheduleRepository::class);
        $this->app->bind(CampaignInterface::class, CampaignRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
