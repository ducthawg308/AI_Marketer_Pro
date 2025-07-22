<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AudienceConfig\AudienceConfigStoreRequest;
use App\Http\Requests\Dashboard\AudienceConfig\AudienceConfigUpdateRequest;
use App\Models\Dashboard\AudienceConfig\Product;
use App\Services\Dashboard\AudienceConfigService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AudienceConfigController extends Controller
{
    public function __construct(private AudienceConfigService $audienceconfigService) {}

    public function index(Request $request): View
    {
        $search = $request->only(['keyword']);
        $items = $this->audienceconfigService->search($search);

        return view('dashboard.audience_config.index', compact('items', 'search'));
    }

    public function create(): View
    {
        $item = new Product();
        return view('dashboard.audience_config.create', compact('item'));
    }

    public function store(AudienceConfigStoreRequest $request): RedirectResponse
    {
        $result = $this->audienceconfigService->create($request->validated());

        if ($result) {
            return redirect()->route('dashboard.audienceconfig.index')
                ->with('toast-success', __('dashboard.add_audience_config_success'));
        }

        return back()->with('toast-error', __('dashboard.add_audience_config_fail'));
    }

    public function edit($id): View
    {
        $item = $this->audienceconfigService->find($id);

        return view('dashboard.audience_config.edit', compact('item'));
    }

    public function update(AudienceConfigUpdateRequest $request, $id): RedirectResponse
    {
        $item = $this->audienceconfigService->update($id, $request->validated());

        if ($item) {
            return redirect()->route('dashboard.audienceconfig.index')
                ->with('toast-success', __('dashboard.update_audience_config_success'));
        }

        return back()->with('toast-error', __('dashboard.update_audience_config_fail'));
    }

    public function destroy($id): RedirectResponse
    {
        $isDestroy = $this->audienceconfigService->delete($id);

        return $isDestroy
            ? redirect()->route('dashboard.audienceconfig.index')
                ->with('toast-success', __('dashboard.delete_audience_config_success'))
            : back()->with('toast-error', __('dashboard.delete_audience_config_fail'));
    }
}