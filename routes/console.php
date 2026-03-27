<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('publish:scheduled-posts')->everyMinute();
// Schedule::command('auto-reply:comments')->everyFiveMinutes();
Schedule::command('auto-reply:comments')->everyMinute();

// Tự động sync analytics từ Facebook API mỗi 5 phút
Schedule::command('sync:campaign-analytics')->everyFiveMinutes();
