<?php

namespace App\Console\Commands;

use App\Models\Dashboard\AutoPublisher\Campaign;
use App\Services\Dashboard\CampaignTracking\CampaignTrackingService;
use Illuminate\Console\Command;
class SyncCampaignAnalyticsCommand extends Command
{
    protected $signature = 'sync:campaign-analytics
                            {--campaign= : Chỉ sync một campaign cụ thể (ID)}
                            {--force : Bỏ qua filter status, sync tất cả campaigns}';

    protected $description = 'Tự động sync analytics từ Facebook API về database cho tất cả campaigns';

    public function handle(CampaignTrackingService $service): int
    {
        try {
            $campaignId = $this->option('campaign');
            $force      = $this->option('force');

            // Xác định campaign IDs cần sync
            if ($campaignId) {
                $campaignIds = [$campaignId];
            } else {
                // Lấy tất cả campaigns đang active (running) hoặc tất cả nếu --force
                $query = Campaign::whereNotNull('id');

                if (!$force) {
                    $query->whereIn('status', ['running', 'completed']);
                }

                $campaigns   = $query->pluck('id')->toArray();
                $campaignIds = !empty($campaigns) ? $campaigns : null;

                $count = count($campaigns);

                if ($count === 0) {
                    return Command::SUCCESS;
                }
            }

            // Thực hiện sync
            $result = $service->syncCampaignAnalytics($campaignIds);

            if ($result['success']) {
                return Command::SUCCESS;
            } else {
                return Command::FAILURE;
            }

        } catch (\Exception $e) {
            return Command::FAILURE;
        }
    }
}
