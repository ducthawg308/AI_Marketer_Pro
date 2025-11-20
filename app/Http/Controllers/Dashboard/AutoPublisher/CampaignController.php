<?php

namespace App\Http\Controllers\Dashboard\AutoPublisher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AutoPublisher\CampaignStoreRequest;
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

    public function create(): View
    {
        $userPages = UserPage::where('user_id', Auth::id())->get();

        return view('dashboard.auto_publisher.campaign.setup', compact('userPages'));
    }

    public function roadmap($id): View
    {
        $campaign = $this->campaignService->find($id);
        if (!$campaign) {
            abort(404);
        }

        // Kiểm tra quyền sở hữu
        if ($campaign->user_id !== Auth::id()) {
            abort(403);
        }

        $user_pages = UserPage::where('user_id', Auth::id())->get();
        $ads = Ad::where('user_id', Auth::id())->get();

        // Generate slots từ campaign
        $slots = $this->campaignService->generateSlots([
            'start_date' => $campaign->start_date,
            'end_date' => $campaign->end_date,
            'frequency' => $campaign->frequency,
            'frequency_config' => $campaign->frequency_config,
            'default_time_start' => $campaign->default_time_start,
            'default_time_end' => $campaign->default_time_end,
        ]);

        // Group slots by date for roadmap display
        $roadmap = [];
        $groupedSlots = collect($slots)->groupBy('date');

        foreach ($groupedSlots as $date => $daySlots) {
            $dateObj = Carbon::createFromFormat('Y-m-d', $date);
            $roadmap[] = [
                'date' => $dateObj,
                'day_name' => $this->getVietnameseDayName($dateObj->dayOfWeek),
                'post_count' => $daySlots->count(),
                'posts' => $daySlots->map(function ($slot, $index) use ($date) {
                    return [
                        'index' => $index,
                        'slot_id' => $date . '_' . $slot['slot_index'],
                        'suggested_time' => $slot['time'],
                        'page_index' => $slot['page_index'],
                    ];
                })->values()->toArray(),
            ];
        }

        // Calculate statistics
        $totalPosts = count($slots);
        $totalDays = $campaign->start_date->diffInDays($campaign->end_date) + 1;
        $totalPlatforms = $user_pages->count();
        $avgPosts = $totalDays > 0 ? round($totalPosts / $totalDays, 1) : 0;

        $statistics = [
            'total_days' => $totalDays,
            'total_posts' => $totalPosts,
            'total_platforms' => $totalPlatforms,
            'avg_posts' => $avgPosts
        ];

        return view('dashboard.auto_publisher.campaign.roadmap', compact(
            'campaign',
            'roadmap',
            'user_pages',
            'ads',
            'statistics'
        ));
    }

    public function store(CampaignStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Prepare attributes using existing schema
        $attributes = [
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'objective' => $request->objective,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'platforms' => $request->platforms,
            'frequency_type' => $request->frequency,
            'default_time_start' => $request->default_time_start,
            'default_time_end' => $request->default_time_end,
            'status' => 'draft',
        ];

        // Set frequency-specific fields based on type
        switch ($request->frequency) {
            case 'daily':
                $attributes['posts_per_day'] = $request->input('frequency_config.posts_per_day', 1);
                break;
            case 'weekly':
                $attributes['weekday_frequency'] = $request->input('frequency_config.posts_per_week', 1);
                break;
            case 'custom':
                $attributes['weekday_frequency'] = 1; // Default
                break;
        }

        $campaign = $this->campaignService->create($attributes);

        if ($campaign) {
            return redirect()->route('dashboard.auto_publisher.campaign.roadmap', $campaign->id)
                ->with('toast-success', 'Chiến dịch đã được tạo. Hãy sắp xếp nội dung cho roadmap.');
        }

        return back()->with('toast-error', 'Không thể tạo chiến dịch. Vui lòng thử lại.')->withInput();
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $item = $this->campaignService->find($id);
        if (!$item) {
            return back()->with('toast-error', 'Không tìm thấy');
        }

        $item = $this->campaignService->update($id, $request->all());
        if ($item) {
            return redirect()->route('dashboard.auto_publisher.campaign.index')->with('toast-success', 'Cập nhật thành công');
        }

        return back()->with('toast-error', 'Cập nhật thất bại');
    }

    public function destroy($id): RedirectResponse
    {
        $isDestroy = $this->campaignService->delete($id);

        return $isDestroy
            ? redirect()->route('dashboard.auto_publisher.campaign.index')->with('toast-success', 'Xóa thành công')
            : back()->with('toast-error', 'Xóa thất bại');
    }

    public function launch(Request $request, $id): RedirectResponse
    {
        $slotsData = json_decode($request->input('slots', '[]'), true);

        $result = $this->campaignService->launchCampaign($id, $slotsData);

        if ($result) {
            return redirect()->route('dashboard.auto_publisher.campaign.index')
                ->with('toast-success', 'Chiến dịch đã được khởi chạy thành công! Hệ thống sẽ tự động đăng bài đúng giờ.');
        }

        return back()->with('toast-error', 'Không thể khởi chạy chiến dịch. Vui lòng thử lại.');
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
}
