<?php

namespace App\Http\Controllers\Dashboard\AutoPublisher;

use App\Http\Controllers\Controller;
use App\Models\Dashboard\AutoPublisher\Campaign;
use App\Models\Dashboard\ContentCreator\Ad;
use App\Models\Facebook\UserPage;
use App\Services\Dashboard\AutoPublisher\CampaignService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CampaignController extends Controller
{
    public function __construct(private CampaignService $campaignService) {}

    public function index(Request $request): View
    {
        $search = $request->only(['keyword']);
        $items = $this->campaignService->search($search);

        return view('dashboard.auto_publisher.campaign.index', compact(['items', 'search']));
    }

    public function roadmap(Request $request): View
    {
        $user_pages = UserPage::where('user_id', Auth::id())->get();
        $ads = Ad::where('user_id', Auth::id())->get();
        
        // Parse dates
        $startDate = Carbon::createFromFormat('d/m/Y', $request->start_date);
        $endDate = Carbon::createFromFormat('d/m/Y', $request->end_date);
        
        // Get posts per day
        $postsPerDay = (int)($request->posts_per_day ?? 2);
        
        // Calculate campaign info
        $campaignInfo = [
            'name' => $request->name,
            'objective' => $request->objective,
            'description' => $request->description,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'frequency' => $request->frequency,
            'posts_per_day' => $postsPerDay,
        ];
        
        // Generate roadmap based on frequency
        $roadmap = [];
        $totalPosts = 0;
        
        switch ($request->frequency) {
            case 'daily':
                $roadmap = $this->generateDailyRoadmap($startDate, $endDate, $postsPerDay);
                $totalPosts = count($roadmap) * $postsPerDay;
                break;
                
            case 'weekly':
                $roadmap = $this->generateWeeklyRoadmap($startDate, $endDate, $postsPerDay);
                $totalPosts = count($roadmap) * $postsPerDay;
                break;
                
            case 'custom':
                $roadmap = $this->generateCustomRoadmap(
                    $startDate, 
                    $endDate,
                    (int)($request->weekday_frequency ?? 0),
                    (int)($request->saturday_frequency ?? 0),
                    (int)($request->sunday_frequency ?? 0)
                );
                $totalPosts = array_sum(array_column($roadmap, 'post_count'));
                break;
        }
        
        // Calculate statistics
        $totalDays = $startDate->diffInDays($endDate) + 1;
        $totalPlatforms = $user_pages->count();
        $avgPosts = $totalDays > 0 ? round($totalPosts / $totalDays, 1) : 0;
        
        $statistics = [
            'total_days' => $totalDays,
            'total_posts' => $totalPosts,
            'total_platforms' => $totalPlatforms,
            'avg_posts' => $avgPosts
        ];
        
        return view('dashboard.auto_publisher.campaign.roadmap', compact(
            'user_pages', 
            'ads', 
            'campaignInfo', 
            'roadmap', 
            'statistics'
        ));
    }

    private function generateDailyRoadmap(Carbon $startDate, Carbon $endDate, int $postsPerDay): array
    {
        $roadmap = [];
        $currentDate = $startDate->copy();
        $suggestedTimes = $this->generateSuggestedTimes($postsPerDay);
        
        while ($currentDate <= $endDate) {
            $posts = [];
            for ($i = 0; $i < $postsPerDay; $i++) {
                $posts[] = [
                    'index' => $i,
                    'suggested_time' => $suggestedTimes[$i] ?? '09:00',
                    'title' => 'Bài viết ' . ($i + 1)
                ];
            }
            
            $roadmap[] = [
                'date' => $currentDate->copy(),
                'day_name' => $this->getVietnameseDayName($currentDate->dayOfWeek),
                'post_count' => $postsPerDay,
                'posts' => $posts
            ];
            $currentDate->addDay();
        }
        
        return $roadmap;
    }

    private function generateWeeklyRoadmap(Carbon $startDate, Carbon $endDate, int $postsPerDay): array
    {
        $roadmap = [];
        $currentDate = $startDate->copy();
        $suggestedTimes = $this->generateSuggestedTimes($postsPerDay);
        
        // Find first Monday
        while ($currentDate->dayOfWeek !== Carbon::MONDAY) {
            $currentDate->addDay();
            if ($currentDate > $endDate) {
                return $roadmap;
            }
        }
        
        while ($currentDate <= $endDate) {
            $posts = [];
            for ($i = 0; $i < $postsPerDay; $i++) {
                $posts[] = [
                    'index' => $i,
                    'suggested_time' => $suggestedTimes[$i] ?? '09:00',
                    'title' => 'Bài viết ' . ($i + 1)
                ];
            }
            
            $roadmap[] = [
                'date' => $currentDate->copy(),
                'day_name' => $this->getVietnameseDayName($currentDate->dayOfWeek),
                'post_count' => $postsPerDay,
                'posts' => $posts
            ];
            $currentDate->addWeek();
        }
        
        return $roadmap;
    }

    private function generateCustomRoadmap(Carbon $startDate, Carbon $endDate, int $weekdayFreq, int $saturdayFreq, int $sundayFreq): array
    {
        $roadmap = [];
        $currentDate = $startDate->copy();
        
        while ($currentDate <= $endDate) {
            $postCount = 0;
            
            // Determine post count based on day of week
            if ($currentDate->dayOfWeek >= Carbon::MONDAY && $currentDate->dayOfWeek <= Carbon::FRIDAY) {
                $postCount = $weekdayFreq;
            } elseif ($currentDate->dayOfWeek === Carbon::SATURDAY) {
                $postCount = $saturdayFreq;
            } elseif ($currentDate->dayOfWeek === Carbon::SUNDAY) {
                $postCount = $sundayFreq;
            }
            
            if ($postCount > 0) {
                $suggestedTimes = $this->generateSuggestedTimes($postCount);
                $posts = [];
                
                for ($i = 0; $i < $postCount; $i++) {
                    $posts[] = [
                        'index' => $i,
                        'suggested_time' => $suggestedTimes[$i] ?? '09:00',
                        'title' => 'Bài viết ' . ($i + 1)
                    ];
                }
                
                $roadmap[] = [
                    'date' => $currentDate->copy(),
                    'day_name' => $this->getVietnameseDayName($currentDate->dayOfWeek),
                    'post_count' => $postCount,
                    'posts' => $posts
                ];
            }
            
            $currentDate->addDay();
        }
        
        return $roadmap;
    }

    private function generateSuggestedTimes(int $postCount): array
    {
        // Base times for optimal posting
        $baseTimes = ['07:00', '09:00', '12:00', '15:00', '18:00', '20:00', '21:00'];
        
        if ($postCount <= count($baseTimes)) {
            // Evenly distribute times
            $step = count($baseTimes) / $postCount;
            $times = [];
            for ($i = 0; $i < $postCount; $i++) {
                $index = (int)floor($i * $step);
                $times[] = $baseTimes[$index];
            }
            return $times;
        }
        
        // If more posts than base times, generate additional times
        $times = $baseTimes;
        while (count($times) < $postCount) {
            $times[] = sprintf('%02d:00', 6 + count($times));
        }
        
        return array_slice($times, 0, $postCount);
    }

    private function getVietnameseDayName(int $dayOfWeek): string
    {
        $days = [
            Carbon::SUNDAY => 'Chủ Nhật',
            Carbon::MONDAY => 'Thứ Hai',
            Carbon::TUESDAY => 'Thứ Ba',
            Carbon::WEDNESDAY => 'Thứ Tư',
            Carbon::THURSDAY => 'Thứ Năm',
            Carbon::FRIDAY => 'Thứ Sáu',
            Carbon::SATURDAY => 'Thứ Bảy'
        ];
        
        return $days[$dayOfWeek] ?? 'Không xác định';
    }

    public function store(Request $request): RedirectResponse
    {
        dd($request->all());
        $attributes = $request->except(['_token']);
        $result = $this->campaignService->create($attributes);

        return $result
            ? redirect()->route('dashboard.auto_publisher.index')->with('toast-success', 'Thêm chiến dịch thành công')
            : back()->with('toast-error', 'Thêm chiến dịch thất bại');
    }

    public function edit($id): View
    {
        $item = $this->campaignService->find($id);
        return view('dashboard.audience_config.edit', compact('item'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $item = $this->campaignService->find($id);
        if (!$item) {
            return back()->with('toast-error', 'Không tìm thấy');
        }

        $item = $this->campaignService->update($id, $request->all());
        if ($item) {
            return redirect()->route('dashboard.audience_config.index')->with('toast-success', 'Cập nhật thành công');
        }

        return back()->with('toast-error', 'Cập nhật thất bại');
    }

    public function destroy($id): RedirectResponse
    {
        $isDestroy = $this->campaignService->delete($id);

        return $isDestroy
            ? redirect()->route('dashboard.audience_config.index')->with('toast-success', 'Xóa thành công')
            : back()->with('toast-error', 'Xóa thất bại');
    }
}  