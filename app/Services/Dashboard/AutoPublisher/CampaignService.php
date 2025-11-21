<?php

namespace App\Services\Dashboard\AutoPublisher;

use App\Repositories\Interfaces\Dashboard\AutoPublisher\CampaignInterface;
use App\Services\BaseService;
use App\Models\Dashboard\AutoPublisher\AdSchedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CampaignService extends BaseService
{
    public function __construct(private CampaignInterface $campaignRepository) {}

    public function create($attributes)
    {
        return $this->campaignRepository->create($attributes);
    }

    public function update($id, $attributes)
    {
        return $this->campaignRepository->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->campaignRepository->delete($id);
    }

    public function find($id)
    {
        return $this->campaignRepository->find($id);
    }

    public function get($conditions = [])
    {
        return $this->campaignRepository->get($conditions);
    }

    public function search($search)
    {
        $search = array_filter($search, fn ($value) => ! is_null($value) && $value !== '');

        return $this->campaignRepository->search($search);
    }

    /**
     * Generate slot roadmap dựa trên campaign frequency
     */
    public function generateSlots($attributes)
    {
        $startDate = Carbon::parse($attributes['start_date']);
        $endDate = isset($attributes['end_date']) ? Carbon::parse($attributes['end_date']) : null;
        $frequency = $attributes['frequency'];
        $config = $attributes['frequency_config'] ?? [];
        $defaultStart = $attributes['default_time_start'] ?? '08:00';
        $defaultEnd = $attributes['default_time_end'] ?? '20:00';
        $platformsCount = $attributes['platforms_count'] ?? 1;

        $slots = [];

        switch ($frequency) {
            case 'daily':
                $postsPerDay = $config['posts_per_day'] ?? 1;
                $slots = $this->generateDailySlots($startDate, $endDate, $postsPerDay, $defaultStart, $defaultEnd, $platformsCount);
                break;

            case 'weekly':
                $postsPerWeek = $config['posts_per_week'] ?? 1;
                $selectedDays = $config['selected_days'] ?? [1]; // Mặc định Thứ Hai
                $slots = $this->generateWeeklySlots($startDate, $endDate, $postsPerWeek, $selectedDays, $defaultStart, $defaultEnd, $platformsCount);
                break;

            case 'custom':
                $dayConfig = $config['days'] ?? [];
                $slots = $this->generateCustomSlots($startDate, $endDate, $dayConfig, $defaultStart, $defaultEnd, $platformsCount);
                break;
        }

        return $slots;
    }

    private function generateDailySlots($startDate, $endDate, $postsPerDay, $timeStart, $timeEnd, $platformsCount)
    {
        $slots = [];
        $currentDate = $startDate->copy();
        $globalSlotIndex = 0; // Counter để rotate pages toàn bộ campaign

        while (!$endDate || $currentDate <= $endDate) {
            for ($i = 0; $i < $postsPerDay; $i++) {
                $slots[] = [
                    'date' => $currentDate->toDateString(),
                    'time' => $this->generateRandomTime($timeStart, $timeEnd, $i, $postsPerDay),
                    'slot_index' => $i,
                    'page_index' => $platformsCount > 1 ? $globalSlotIndex % $platformsCount : 0,
                ];
                $globalSlotIndex++;
            }
            $currentDate->addDay();
        }

        return $slots;
    }

    private function generateWeeklySlots($startDate, $endDate, $postsPerWeek, $selectedDays, $timeStart, $timeEnd, $platformsCount)
    {
        $slots = [];
        $currentDate = $startDate->copy();
        $globalSlotIndex = 0; // Counter để rotate pages toàn bộ campaign

        while (!$endDate || $currentDate <= $endDate) {
            if (in_array($currentDate->dayOfWeek, $selectedDays)) {
                for ($i = 0; $i < $postsPerWeek; $i++) {
                    $slots[] = [
                        'date' => $currentDate->toDateString(),
                        'time' => $this->generateRandomTime($timeStart, $timeEnd, $i, $postsPerWeek),
                        'slot_index' => $i,
                        'page_index' => $platformsCount > 1 ? $globalSlotIndex % $platformsCount : 0,
                    ];
                    $globalSlotIndex++;
                }
            }
            $currentDate->addDay();
        }

        return $slots;
    }

    private function generateCustomSlots($startDate, $endDate, $dayConfig, $timeStart, $timeEnd, $platformsCount)
    {
        // dayConfig: ['monday' => 2, 'tuesday' => 1, ...]
        $dayMap = [
            'monday' => Carbon::MONDAY,
            'tuesday' => Carbon::TUESDAY,
            'wednesday' => Carbon::WEDNESDAY,
            'thursday' => Carbon::THURSDAY,
            'friday' => Carbon::FRIDAY,
            'saturday' => Carbon::SATURDAY,
            'sunday' => Carbon::SUNDAY,
        ];

        $slots = [];
        $currentDate = $startDate->copy();
        $globalSlotIndex = 0; // Counter để rotate pages toàn bộ campaign

        while (!$endDate || $currentDate <= $endDate) {
            $dayName = strtolower($currentDate->format('l'));
            $posts = $dayConfig[$dayName] ?? 0;

            for ($i = 0; $i < $posts; $i++) {
                $slots[] = [
                    'date' => $currentDate->toDateString(),
                    'time' => $this->generateRandomTime($timeStart, $timeEnd, $i, $posts),
                    'slot_index' => $i,
                    'page_index' => $platformsCount > 1 ? $globalSlotIndex % $platformsCount : 0,
                ];
                $globalSlotIndex++;
            }

            $currentDate->addDay();
        }

        return $slots;
    }

    private function generateRandomTime($start, $end, $slotIndex, $totalSlots)
    {
        $startTime = Carbon::createFromTimeString($start);
        $endTime = Carbon::createFromTimeString($end);

        $totalMinutes = $startTime->diffInMinutes($endTime);
        $interval = $totalSlots > 1 ? $totalMinutes / ($totalSlots - 1) : 0;

        $randomMinutes = rand(0, 30); // Random ±30 phút để tránh trùng giờ
        $slotMinutes = floor($slotIndex * $interval) + $randomMinutes;

        $scheduledTime = $startTime->copy()->addMinutes($slotMinutes);

        return $scheduledTime->format('H:i');
    }

    /**
     * Launch campaign: tạo AdSchedules bulk
     */
    public function launchCampaign($campaignId, $slotsData)
    {
        $campaign = $this->find($campaignId);
        if (!$campaign || $campaign->status !== 'draft') {
            return false;
        }

        $pages = $campaign->getSelectedPages();

        DB::transaction(function () use ($campaign, $slotsData, $pages) {
            $schedulesData = [];

            foreach ($slotsData as $slot) {
                if (!isset($slot['ad_id'])) continue; // Bỏ qua slot trống

                // Rotate pages cho mỗi slot
                $pageId = $pages[$slot['page_index'] % $pages->count()]->id;

                $schedulesData[] = [
                    'ad_id' => $slot['ad_id'],
                    'campaign_id' => $campaign->id,
                    'user_page_id' => $pageId,
                    'scheduled_time' => Carbon::createFromFormat('Y-m-d H:i', $slot['date'] . ' ' . $slot['time'], 'Asia/Ho_Chi_Minh'),
                    'status' => 'pending',
                ];
            }

            // Bulk insert vào ad_schedule
            AdSchedule::insert($schedulesData);

            // Update campaign status
            $campaign->update(['status' => 'running']);
        });

        return true;
    }
}
