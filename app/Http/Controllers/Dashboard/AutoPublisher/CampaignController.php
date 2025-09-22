<?php

namespace App\Http\Controllers\Dashboard\AutoPublisher;

use App\Http\Controllers\Controller;
// use App\Http\Requests\Dashboard\AudienceConfig\AudienceConfigStoreRequest;
// use App\Http\Requests\Dashboard\AudienceConfig\AudienceConfigUpdateRequest;
use App\Models\Dashboard\AutoPublisher\Campaign;
use App\Services\Dashboard\AutoPublisher\CampaignService;
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

    public function preview(Request $request): View
    {
        return view('dashboard.auto_publisher.campaign.roadmap');
    }

    public function store(Request $request): RedirectResponse
    {
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

