<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AudienceConfig\AudienceConfigStoreRequest;
use App\Http\Requests\Dashboard\AudienceConfig\AudienceConfigUpdateRequest;
use App\Models\Dashboard\AudienceConfig\Product;
use App\Services\Dashboard\AudienceConfigService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AudienceConfigController extends Controller
{
    public function __construct(private AudienceConfigService $audienceConfigService) {}

    public function index(Request $request): View
    {
        $search = $request->only(['keyword']);
        $items = $this->audienceConfigService->search($search);

        return view('dashboard.audience_config.index', compact(['items', 'search']));
    }

    public function create(): View
    {
        $item = new Product();

        return view('dashboard.audience_config.create', compact('item'));
    }

    public function store(AudienceConfigStoreRequest $request): RedirectResponse
    {
        $attributes = $request->except(['_token']);
        $attributes['user_id'] = Auth::id();

        $result = $this->audienceConfigService->create($attributes);

        return $result
            ? redirect()->route('dashboard.audience_config.index')->with('toast-success', __('dashboard.add_audience_config_success'))
            : back()->with('toast-error', __('dashboard.add_audience_config_fail'));
    }

    public function edit($id): View
    {
        $item = $this->audienceConfigService->find($id);

        return view('dashboard.audience_config.edit', compact('item'));
    }

    public function update(AudienceConfigUpdateRequest $request, $id): RedirectResponse
    {
        $item = $this->audienceConfigService->find($id);
        if (! $item) {
            return back()->with('toast-error', __('dashboard.not_found'));
        }

        $item = $this->audienceConfigService->update($id, $request->all());
        if ($item) {
            return redirect()->route('dashboard.audience_config.index')->with('toast-success', __('dashboard.update_audience_config_success'));
        }

        return back()->with('toast-error', __('dashboard.update_audience_config_fail'));
    }

    public function destroy($id): RedirectResponse
    {
        $isDestroy = $this->audienceConfigService->delete($id);

        return $isDestroy
            ? redirect()->route('dashboard.audience_config.index')->with('toast-success', __('dashboard.delete_audience_config_success'))
            : back()->with('toast-error', __('dashboard.delete_audience_config_fail'));
    }
}

