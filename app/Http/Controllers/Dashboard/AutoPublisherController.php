<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AutoPublisher\AutoPublisherStoreRequest;
use App\Http\Requests\Dashboard\AutoPublisher\AutoPublisherUpdateRequest;
use App\Models\Dashboard\AutoPublisher\AdSchedule;
use App\Models\Dashboard\ContentCreator\Ad;
use App\Models\Facebook\UserPage;
use App\Services\Dashboard\AutopublisherService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AutoPublisherController extends Controller
{
    public function __construct(private AutopublisherService $autoPublisherService) {}

    public function index(Request $request): View
    {
        $search = $request->only(['keyword']);
        $items = $this->autoPublisherService->search($search);
        $user_pages = UserPage::where('user_id', Auth::id())->get();
        $ads = Ad::where('user_id', Auth::id())->get();
        $scheduledAds = AdSchedule::with(['ad', 'userPage'])
        ->whereHas('ad', fn($q) => $q->where('user_id', Auth::id()))
        ->orderBy('scheduled_time', 'asc')
        ->get();

        return view('dashboard.auto_publisher.index', compact(['items', 'search', 'user_pages', 'scheduledAds', 'ads']));
    }

    public function createFromNormal(Request $request): View
    {
        $ads = Ad::where('user_id', Auth::id())->get();
        $user_pages = UserPage::where('user_id', Auth::id())->get();
        return view('dashboard.auto_publisher.normal-scheduling', compact(['user_pages', 'ads']));
    }

    public function createFromCampaign(Request $request): View
    {
        $ads = Ad::where('user_id', Auth::id())->get();
        $user_pages = UserPage::where('user_id', Auth::id())->get();
        return view('dashboard.auto_publisher.campaign-scheduling', compact(['user_pages', 'ads']));
    }

    public function store(AutoPublisherStoreRequest $request): RedirectResponse
    {
        
        $attributes = $request->except(['_token']);
        $attributes['user_id'] = Auth::id();
        $attributes['scheduled_time'] = Carbon::createFromFormat('d/m/Y H:i', $attributes['scheduled_time'])->format('Y-m-d H:i:s');

        $success = true;

        foreach ($attributes['selected_ads'] as $adId) {
            foreach ($attributes['selected_pages'] as $pageId) {
                $scheduleAttributes = [
                    'ad_id' => $adId,
                    'user_page_id' => $pageId,
                    'scheduled_time' => $attributes['scheduled_time'],
                    'user_id' => $attributes['user_id'],
                    'status' => 'pending',
                ];

                $result = $this->autoPublisherService->create($scheduleAttributes);

                if (!$result) {
                    $success = false;
                }  
            }
        }

        return $success
            ? redirect()->route('dashboard.auto_publisher.index')->with('toast-success', __('dashboard.add_auto_publisher_success'))
            : back()->with('toast-error', __('dashboard.add_auto_publisher_fail'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $item = $this->autoPublisherService->find($id);
        if (!$item) {
            return back()->with('toast-error', __('dashboard.not_found'));
        }

        $data = $request->all();
        if (isset($data['scheduled_time'])) {
            $data['scheduled_time'] = Carbon::createFromFormat('d/m/Y H:i', $data['scheduled_time'])->format('Y-m-d H:i:s');
        }

        $item = $this->autoPublisherService->update($id, $data);
        if ($item) {
            return redirect()->route('dashboard.auto_publisher.index')->with('toast-success', __('dashboard.update_auto_publisher_success'));
        }

        return back()->with('toast-error', __('dashboard.update_auto_publisher_fail'));
    }

    public function destroy($id): RedirectResponse
    {
        $isDestroy = $this->autoPublisherService->delete($id);

        return $isDestroy
            ? redirect()->route('dashboard.auto_publisher.index')->with('toast-success', __('dashboard.delete_auto_publisher_success'))
            : back()->with('toast-error', __('dashboard.delete_auto_publisher_fail'));
    }
}