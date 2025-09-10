<?php

namespace App\Http\Controllers\Dashboard\MarketAnalysis;

use App\Http\Controllers\Controller;
// use App\Http\Requests\Dashboard\AudienceConfig\AudienceConfigStoreRequest;
// use App\Http\Requests\Dashboard\AudienceConfig\AudienceConfigUpdateRequest;
use App\Models\Dashboard\MarketAnalysis\MarketResearch;
use App\Services\Dashboard\MarketAnalysis\MarketAnalysisService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MarketAnalysisController extends Controller
{
    public function __construct(private MarketAnalysisService $marketAnalysisService) {}

    public function index(Request $request): View
    {
        $search = $request->only(['keyword']);
        $items = $this->marketAnalysisService->search($search);

        return view('dashboard.market_analysis.index', compact(['items', 'search']));
    }

    public function create(): View
    {
        $item = new MarketResearch();

        return view('dashboard.market_analysis.create', compact('item'));
    }

    public function store(Request $request): RedirectResponse
    {
        $attributes = $request->except(['_token']);
        $attributes['user_id'] = Auth::id();

        $result = $this->marketAnalysisService->create($attributes);

        return $result
            ? redirect()->route('dashboard.market_analysis.index')->with('toast-success', __('dashboard.add_market_analysis_success'))
            : back()->with('toast-error', __('dashboard.add_market_analysis_fail'));
    }

    public function edit($id): View
    {
        $item = $this->marketAnalysisService->find($id);

        return view('dashboard.market_analysis.edit', compact('item'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $item = $this->marketAnalysisService->find($id);
        if (! $item) {
            return back()->with('toast-error', __('dashboard.not_found'));
        }

        $item = $this->marketAnalysisService->update($id, $request->all());
        if ($item) {
            return redirect()->route('dashboard.market_analysis.index')->with('toast-success', __('dashboard.update_market_analysis_success'));
        }

        return back()->with('toast-error', __('dashboard.update_market_analysis_fail'));
    }

    public function destroy($id): RedirectResponse
    {
        $isDestroy = $this->marketAnalysisService->delete($id);

        return $isDestroy
            ? redirect()->route('dashboard.market_analysis.index')->with('toast-success', __('dashboard.delete_market_analysis_success'))
            : back()->with('toast-error', __('dashboard.delete_market_analysis_fail'));
    }
}

