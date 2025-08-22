<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AutoPublisher\AutoPublisherStoreRequest;
use App\Http\Requests\Dashboard\AutoPublisher\AutoPublisherUpdateRequest;
use App\Models\Dashboard\AutoPublisher\AdSchedule;
use App\Models\Dashboard\ContentCreator\Ad;
use App\Models\Facebook\UserPage;
use App\Services\Dashboard\AutopublisherService;
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

        $ads = Ad::where('user_id', Auth::id())->get();
        $user_pages = UserPage::where('user_id', Auth::id())->get();
        $scheduledAds = AdSchedule::with(['ad', 'userPage'])
        ->whereHas('ad', fn($q) => $q->where('user_id', Auth::id()))
        ->where('scheduled_time', '>=', now())
        ->orderBy('scheduled_time', 'asc')
        ->get();

        return view('dashboard.auto_publisher.index', compact(['items', 'search', 'ads', 'user_pages', 'scheduledAds']));
    }

    public function create(): View
    {
        $item = new AdSchedule();

        return view('dashboard.auto_publisher.create', compact('item'));
    }

    public function store(Request $request): RedirectResponse
    {
        $attributes = $request->except(['_token']);
        $attributes['user_id'] = Auth::id();

        $result = $this->autoPublisherService->create($attributes);

        return $result
            ? redirect()->route('dashboard.auto_publisher.index')->with('toast-success', __('dashboard.add_auto_publisher_success'))
            : back()->with('toast-error', __('dashboard.add_auto_publisher_fail'));
    }

    public function edit($id): View
    {
        $item = $this->autoPublisherService->find($id);

        return view('dashboard.auto_publisher.edit', compact('item'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $item = $this->autoPublisherService->find($id);
        if (! $item) {
            return back()->with('toast-error', __('dashboard.not_found'));
        }

        $item = $this->autoPublisherService->update($id, $request->all());
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