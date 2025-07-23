<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AiCreator\AiCreatorStoreRequest;
use App\Http\Requests\Dashboard\AiCreator\AiCreatorUpdateRequest;
use App\Http\Requests\Dashboard\AiCreator\AiSettingUpdateRequest;
use App\Models\Dashboard\AudienceConfig\Product;
use App\Services\Dashboard\AiCreatorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AiCreatorController extends Controller
{
    public function __construct(private AiCreatorService $aiCreatorService) {}

    public function index(Request $request): View
    {
        $search = $request->only(['keyword']);
        $items = $this->aiCreatorService->search($search);
        $products = Product::where('user_id', Auth::id())->get();
        $setting = $this->aiCreatorService->getSetting(Auth::id());

        return view('dashboard.ai_creator.index', compact('items', 'products', 'setting', 'search'));
    }

    public function store(AiCreatorStoreRequest $request): RedirectResponse
    {

        dd($request);
        $attributes = $request->except(['_token']);
        $attributes['user_id'] = Auth::id();

        $result = $this->aiCreatorService->create($attributes);

        return $result
            ? redirect()->route('dashboard.aicreator.index')->with('toast-success', __('dashboard.add_ad_success'))
            : back()->with('toast-error', __('dashboard.add_ad_fail'));
    }

    public function show($id): View
    {
        $item = $this->aiCreatorService->find($id);

        return view('dashboard.ai_creator.show', compact('item'));
    }

    public function edit($id): View
    {
        $item = $this->aiCreatorService->find($id);

        return view('dashboard.ai_creator.edit', compact('item'));
    }

    public function update(AiCreatorUpdateRequest $request, $id): RedirectResponse
    {
        $item = $this->aiCreatorService->find($id);
        if (! $item) {
            return back()->with('toast-error', __('dashboard.not_found'));
        }

        $item = $this->aiCreatorService->update($id, $request->all());
        if ($item) {
            return redirect()->route('dashboard.aicreator.index')->with('toast-success', __('dashboard.update_ad_success'));
        }

        return back()->with('toast-error', __('dashboard.update_ad_fail'));
    }

    public function destroy($id): RedirectResponse
    {
        $isDestroy = $this->aiCreatorService->delete($id);

        return $isDestroy
            ? redirect()->route('dashboard.aicreator.index')->with('toast-success', __('dashboard.delete_ad_success'))
            : back()->with('toast-error', __('dashboard.delete_ad_fail'));
    }

    public function updateSetting(AiSettingUpdateRequest $request): RedirectResponse
    {
        $userId = Auth::id();
        $data = $request->validated();
        
        $result = $this->aiCreatorService->updateSetting($userId, $data);

        return $result
            ? redirect()->route('dashboard.aicreator.index')->with('toast-success', __('dashboard.update_ai_setting_success'))
            : back()->with('toast-error', __('dashboard.update_ai_setting_fail'));
    }
}