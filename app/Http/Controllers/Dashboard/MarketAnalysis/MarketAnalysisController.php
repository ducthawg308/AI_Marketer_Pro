<?php

namespace App\Http\Controllers\Dashboard\MarketAnalysis;

use App\Http\Controllers\Controller;
use App\Models\Dashboard\AudienceConfig\Product;
// use App\Http\Requests\Dashboard\AudienceConfig\AudienceConfigStoreRequest;
// use App\Http\Requests\Dashboard\AudienceConfig\AudienceConfigUpdateRequest;
use App\Models\Dashboard\MarketAnalysis\MarketResearch;
use App\Services\Dashboard\MarketAnalysis\MarketAnalysisService;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MarketAnalysisController extends Controller
{
    public function __construct(private MarketAnalysisService $marketAnalysisService) {}

    public function index(): View
    {
        $products = Product::where('user_id', Auth::id())->get();
        return view('dashboard.market_analysis.index', compact('products'));
    }

    public function create(): View
    {
        $item = new MarketResearch();

        return view('dashboard.market_analysis.create', compact('item'));
    }

    // public function analyze(Request $request): View
    // {
    //     $attributes = $request->all();
    //     $type = $attributes['research_type'];
    //     $products = Product::where('user_id', Auth::id())->get();

    //     $data = match ($type) {
    //         'consumer'   => $this->marketAnalysisService->analysis($attributes),
    //         'competitor' => $this->marketAnalysisService->analysis($attributes),
    //         'trend'      => $this->marketAnalysisService->analysis($attributes),
    //         default      => null,
    //     };

    //     Log::info('Phân tích thị trường - Dữ liệu trend:', ['data' => $data]);

    //     return view('dashboard.market_analysis.index', compact('data', 'type', 'products'));
    // }


    public function analyze(Request $request)
    {
        try {
            $attributes = $request->all();
            $type = $attributes['research_type'];
            
            $data = match ($type) {
                'consumer'   => $this->marketAnalysisService->analysis($attributes),
                'competitor' => $this->marketAnalysisService->analysis($attributes),
                'trend'      => $this->marketAnalysisService->analysis($attributes),
                default      => null,
            };

            Log::info('Phân tích thị trường - Dữ liệu:', ['type' => $type, 'data' => $data]);

            if ($request->ajax()) {
                $html = $this->renderAnalysisResult($type, $data);
                
                return response()->json([
                    'success' => true,
                    'html' => $html,
                    'type' => $type,
                    'message' => 'Phân tích thành công'
                ]);
            }
        } catch (ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dữ liệu không hợp lệ: ' . implode(', ', $e->validator->errors()->all()),
                    'errors' => $e->validator->errors()
                ], 422);
            }
            
            throw $e;
        } catch (\Exception $e) {
            Log::error('Lỗi phân tích thị trường:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra trong quá trình phân tích. Vui lòng thử lại sau.'
                ], 500);
            }

            throw $e;
        }
    }

    private function renderAnalysisResult($type, $data)
    {
        $typeNames = [
            'consumer' => 'Người tiêu dùng',
            'competitor' => 'Đối thủ cạnh tranh', 
            'trend' => 'Xu hướng thị trường'
        ];
        
        $typeName = $typeNames[$type] ?? 'Phân tích';
        
        $typeIcons = [
            'consumer' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>',
            'competitor' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>',
            'trend' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>'
        ];
        
        $icon = $typeIcons[$type] ?? $typeIcons['consumer'];
        
        $analysisHtml = view("dashboard.market_analysis.research.{$type}-analysis", ['data' => $data])->render();
        
        return '
        <!-- Header kết quả -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 mb-6 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-purple-50 p-6">
                <h3 class="text-2xl font-bold text-gray-900 flex items-center">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            ' . $icon . '
                        </svg>
                    </div>
                    Kết quả phân tích
                </h3>
                <p class="text-gray-600 mt-1">Dữ liệu được cập nhật theo thời gian thực</p>
            </div>
            
            <!-- Tabs cho các loại phân tích -->
            <div class="border-b border-gray-200">
                <nav class="flex px-6">
                    <button class="py-4 px-6 border-b-2 border-primary-500 text-primary-600 font-medium text-sm flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            ' . $icon . '
                        </svg>
                        <span>' . $typeName . '</span>
                    </button>
                </nav>
            </div>

            <div class="p-6">
                ' . $analysisHtml . '
            </div>
        </div>';
    }

    public function store(Request $request): RedirectResponse
    {
        $attributes = $request->except(['_token']);

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
