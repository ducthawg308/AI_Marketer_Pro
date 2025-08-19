<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ContentCreator\ContentCreatorStoreRequest;
use App\Http\Requests\Dashboard\ContentCreator\ContentCreatorUpdateRequest;
use App\Http\Requests\Dashboard\ContentCreator\AiSettingUpdateRequest;
use App\Models\Dashboard\AudienceConfig\Product;
use App\Models\Dashboard\ContentCreator\Ad;
use App\Services\Dashboard\contentCreatorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ContentCreatorController extends Controller
{
    public function __construct(private ContentCreatorService $contentCreatorService) {}

    public function index(Request $request): View
    {
        $search = $request->only(['keyword']);
        $items = $this->contentCreatorService->search($search);
        $products = Product::where('user_id', Auth::id())->get();

        $totalContent = Ad::where('user_id', Auth::id())->count();
        $aiContent = Ad::where('user_id', Auth::id())->where('type', 'product')->count();
        $linkContent = Ad::where('user_id', Auth::id())->where('type', 'link')->count();
        $manualContent = Ad::where('user_id', Auth::id())->where('type', 'manual')->count();

        return view('dashboard.content_creator.index', compact('items', 'products', 'search', 'totalContent', 'aiContent', 'linkContent', 'manualContent'));
    }

    public function createFromProduct(Request $request): View
    {
        $products = Product::where('user_id', Auth::id())->get();
        $setting = $this->contentCreatorService->getSetting(Auth::id());

        return view('dashboard.content_creator.create_ai', compact('products', 'setting'));
    }

    public function createFromLink(Request $request): View
    {
        $setting = $this->contentCreatorService->getSetting(Auth::id());

        return view('dashboard.content_creator.create_link', compact('setting'));
    }

    public function createFromManual(Request $request): View
    {
        return view('dashboard.content_creator.create_manual');
    }

    public function store(ContentCreatorStoreRequest $request): RedirectResponse
    {
        $attributes = $request->validated();

        $result = match ($attributes['type']) {
            'manual'  => $this->contentCreatorService->createManual($attributes),
            'product' => $this->contentCreatorService->createFromProduct($attributes),
            'link'    => $this->contentCreatorService->createFromLink($attributes),
            default   => null,
        };

        return $result
            ? redirect()->route('dashboard.content_creator.index')->with('toast-success', __('dashboard.add_ad_success'))
            : back()->with('toast-error', __('dashboard.add_ad_fail'));
    }

    public function edit($id): View
    {
        $item = $this->contentCreatorService->find($id);

        return view('dashboard.content_creator.edit', compact('item'));
    }

    public function update(ContentCreatorUpdateRequest $request, $id): RedirectResponse
    {
        $item = $this->contentCreatorService->find($id);
        if (! $item) {
            return back()->with('toast-error', __('dashboard.not_found'));
        }

        $item = $this->contentCreatorService->update($id, $request->all());

        return $item
            ? redirect()->route('dashboard.content_creator.index')->with('toast-success', __('dashboard.update_ad_success'))
            : back()->with('toast-error', __('dashboard.update_ad_fail'));
    }

    public function destroy($id): RedirectResponse
    {
        $isDestroy = $this->contentCreatorService->delete($id);

        return $isDestroy
            ? redirect()->route('dashboard.content_creator.index')->with('toast-success', __('dashboard.delete_ad_success'))
            : back()->with('toast-error', __('dashboard.delete_ad_fail'));
    }

    public function updateSetting(AiSettingUpdateRequest $request): RedirectResponse
    {
        $userId = Auth::id();
        $data = $request->validated();
        
        $result = $this->contentCreatorService->updateSetting($userId, $data);

        return $result
            ? redirect()->route('dashboard.content_creator.index')->with('toast-success', __('dashboard.update_ai_setting_success'))
            : back()->with('toast-error', __('dashboard.update_ai_setting_fail'));
    }
}