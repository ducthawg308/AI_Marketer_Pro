<?php

namespace App\Console\Commands;

use App\Services\Dashboard\AutoPublisherService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PublishScheduledPosts extends Command
{
    protected $signature = 'publish:scheduled-posts';
    protected $description = 'Publish scheduled posts to Facebook based on scheduled_publish_time';

    protected $autoPublisherService;

    public function __construct(AutoPublisherService $autoPublisherService)
    {
        parent::__construct();
        $this->autoPublisherService = $autoPublisherService;
    }

    public function handle()
    {
        $currentTime = Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString();

        $schedules = $this->autoPublisherService->get([
            ['status', '=', 'pending'],
            ['scheduled_time', '<=', $currentTime],
        ]);

        $this->info('Loc: ' . json_encode($schedules->toArray()));
        $this->info('Count: ' . $schedules->count());

        if ($schedules->isEmpty()) {
            $this->info('Không có bài đăng nào được lên lịch để xuất bản.');
            return;
        }

        foreach ($schedules as $schedule) {
            $this->info("ID lịch xử lý: {$schedule->id}");
            try {
                $result = $this->autoPublisherService->postToPage($schedule->id);
                if ($result) {
                    $this->info("Đã xuất bản bài viết thành công cho ID lịch trình: {$schedule->id}");
                } else {
                    $this->error("Không thể đăng bài viết cho ID lịch trình: {$schedule->id}");
                }
            } catch (\Exception $e) {
                Log::error("Lỗi xử lý ID lịch biểu {$schedule->id}: " . $e->getMessage());
                $this->error("Lỗi xử lý ID lịch biểu {$schedule->id}: " . $e->getMessage());
            }
        }

        $this->info('Đã hoàn tất xử lý các bài đăng theo lịch trình.');
    }
}