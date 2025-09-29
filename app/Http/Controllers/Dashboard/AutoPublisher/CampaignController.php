<?php

namespace App\Http\Controllers\Dashboard\AutoPublisher;

use App\Http\Controllers\Controller;
// use App\Http\Requests\Dashboard\AudienceConfig\AudienceConfigStoreRequest;
// use App\Http\Requests\Dashboard\AudienceConfig\AudienceConfigUpdateRequest;
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

    // public function roadmap(Request $request): View
    // {
    //     dd($request->all());
    //     $user_pages = UserPage::where('user_id', Auth::id())->get();
    //     $ads = Ad::where('user_id', Auth::id())->get();
    //     return view('dashboard.auto_publisher.campaign.roadmap', compact('user_pages', 'ads'));
    // }
    public function roadmap(Request $request): View
    {
        $user_pages = UserPage::where('user_id', Auth::id())->get();
        $ads = Ad::where('user_id', Auth::id())->get();
        
        // Parse dates
        $startDate = Carbon::createFromFormat('d/m/Y', $request->start_date);
        $endDate = Carbon::createFromFormat('d/m/Y', $request->end_date);
        
        // Calculate campaign info
        $campaignInfo = [
            'name' => $request->name,
            'objective' => $request->objective,
            'description' => $request->description,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'frequency' => $request->frequency,
        ];
        
        // Generate roadmap based on frequency
        $roadmap = [];
        $totalPosts = 0;
        
        switch ($request->frequency) {
            case 'daily':
                $roadmap = $this->generateDailyRoadmap($startDate, $endDate);
                $totalPosts = count($roadmap) * 2; // 2 posts per day
                break;
                
            case 'weekly':
                $roadmap = $this->generateWeeklyRoadmap($startDate, $endDate);
                $totalPosts = count($roadmap) * 2; // 2 posts per week
                break;
                
            case 'custom':
                $roadmap = $this->generateCustomRoadmap(
                    $startDate, 
                    $endDate,
                    (int)$request->weekday_frequency,
                    (int)$request->saturday_frequency,
                    (int)$request->sunday_frequency
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

    private function generateDailyRoadmap(Carbon $startDate, Carbon $endDate): array
    {
        $roadmap = [];
        $currentDate = $startDate->copy();
        
        while ($currentDate <= $endDate) {
            $roadmap[] = [
                'date' => $currentDate->copy(),
                'day_name' => $this->getVietnameseDayName($currentDate->dayOfWeek),
                'post_count' => 2,
                'posts' => [
                    [
                        'index' => 0,
                        'suggested_time' => '09:00',
                        'title' => 'Bài viết 1'
                    ],
                    [
                        'index' => 1,
                        'suggested_time' => '18:00',
                        'title' => 'Bài viết 2'
                    ]
                ]
            ];
            $currentDate->addDay();
        }
        
        return $roadmap;
    }

    private function generateWeeklyRoadmap(Carbon $startDate, Carbon $endDate): array
    {
        $roadmap = [];
        $currentDate = $startDate->copy();
        
        // Find first Monday
        while ($currentDate->dayOfWeek !== Carbon::MONDAY) {
            $currentDate->addDay();
            if ($currentDate > $endDate) {
                return $roadmap;
            }
        }
        
        while ($currentDate <= $endDate) {
            $roadmap[] = [
                'date' => $currentDate->copy(),
                'day_name' => $this->getVietnameseDayName($currentDate->dayOfWeek),
                'post_count' => 2,
                'posts' => [
                    [
                        'index' => 0,
                        'suggested_time' => '09:00',
                        'title' => 'Bài viết 1'
                    ],
                    [
                        'index' => 1,
                        'suggested_time' => '18:00',
                        'title' => 'Bài viết 2'
                    ]
                ]
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
                $posts = [];
                $times = ['09:00', '12:00', '15:00', '18:00', '21:00'];
                
                for ($i = 0; $i < $postCount; $i++) {
                    $posts[] = [
                        'index' => $i,
                        'suggested_time' => $times[$i] ?? '09:00',
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
            ? redirect()->route('dashboard.audience_config.index')->with('toast-success', __('dashboard.add_audience_config_success'))
            : back()->with('toast-error', __('dashboard.add_audience_config_fail'));
    }

    public function edit($id): View
    {
        $item = $this->campaignService->find($id);

        return view('dashboard.audience_config.edit', compact('item'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $item = $this->campaignService->find($id);
        if (! $item) {
            return back()->with('toast-error', __('dashboard.not_found'));
        }

        $item = $this->campaignService->update($id, $request->all());
        if ($item) {
            return redirect()->route('dashboard.audience_config.index')->with('toast-success', __('dashboard.update_audience_config_success'));
        }

        return back()->with('toast-error', __('dashboard.update_audience_config_fail'));
    }

    public function destroy($id): RedirectResponse
    {
        $isDestroy = $this->campaignService->delete($id);

        return $isDestroy
            ? redirect()->route('dashboard.audience_config.index')->with('toast-success', __('dashboard.delete_audience_config_success'))
            : back()->with('toast-error', __('dashboard.delete_audience_config_fail'));
    }
}

