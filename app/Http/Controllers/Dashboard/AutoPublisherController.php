<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AudienceConfig\AudienceConfigStoreRequest;
use App\Http\Requests\Dashboard\AudienceConfig\AudienceConfigUpdateRequest;
use App\Models\Dashboard\AutoPublisher\AdSchedule;
use App\Models\Dashboard\ContentCreator\Ad;
use App\Models\Facebook\UserPage;
use App\Services\Dashboard\AutopublisherService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AutopublisherController extends Controller
{
    public function __construct(private AutopublisherService $autopublisherService) {}

    public function index(Request $request): View
    {
        $search = $request->only(['keyword']);
        $items = $this->autopublisherService->search($search);

        $ads = Ad::where('user_id', Auth::id())->get();
        $user_pages = UserPage::where('user_id', Auth::id())->get();

        return view('dashboard.auto_publisher.index', compact(['items', 'search','ads','user_pages']));
    }

    public function create(): View
    {
        $item = new AdSchedule();

        return view('dashboard.auto_publisher.create', compact('item'));
    }

    public function store(AudienceConfigStoreRequest $request): RedirectResponse
    {
        $attributes = $request->except(['_token']);
        $attributes['user_id'] = Auth::id();

        $result = $this->autopublisherService->create($attributes);

        return $result
            ? redirect()->route('dashboard.auto_publisher.index')->with('toast-success', __('dashboard.add_auto_publisher_success'))
            : back()->with('toast-error', __('dashboard.add_auto_publisher_fail'));
    }

    public function edit($id): View
    {
        $item = $this->autopublisherService->find($id);

        return view('dashboard.auto_publisher.edit', compact('item'));
    }

    public function update(AudienceConfigUpdateRequest $request, $id): RedirectResponse
    {
        $item = $this->autopublisherService->find($id);
        if (! $item) {
            return back()->with('toast-error', __('dashboard.not_found'));
        }

        $item = $this->autopublisherService->update($id, $request->all());
        if ($item) {
            return redirect()->route('dashboard.auto_publisher.index')->with('toast-success', __('dashboard.update_auto_publisher_success'));
        }

        return back()->with('toast-error', __('dashboard.update_auto_publisher_fail'));
    }

    public function destroy($id): RedirectResponse
    {
        $isDestroy = $this->autopublisherService->delete($id);

        return $isDestroy
            ? redirect()->route('dashboard.auto_publisher.index')->with('toast-success', __('dashboard.delete_auto_publisher_success'))
            : back()->with('toast-error', __('dashboard.delete_auto_publisher_fail'));
    }
}

