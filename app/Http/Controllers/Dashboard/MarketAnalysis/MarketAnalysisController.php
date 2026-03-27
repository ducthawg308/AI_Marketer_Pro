<?php

namespace App\Http\Controllers\Dashboard\MarketAnalysis;

use App\Http\Controllers\Controller;
use App\Models\Dashboard\AudienceConfig\Product;
use App\Models\Dashboard\MarketAnalysis\MarketResearch;
use App\Services\Dashboard\MarketAnalysis\MarketAnalysisService;
use Illuminate\Validation\ValidationException;
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
        $analyses = MarketResearch::whereHas('product', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $products = Product::where('user_id', Auth::id())->get();

        return view('dashboard.market_analysis.index', compact('analyses', 'products'));
    }

    public function create(): View
    {
        $item = new MarketResearch();

        return view('dashboard.market_analysis.create', compact('item'));
    }

    public function show($id): View
    {
        $analysis = MarketResearch::whereHas('product', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->with('product')
            ->findOrFail($id);

        $analysisData = $analysis->analysis_data;
        Log::info('Dữ liệu từ database cho show method:', ['analysisData' => $analysisData]);

        return view('dashboard.market_analysis.show', compact('analysis', 'analysisData'));
    }

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

            if (isset($data['success']) && !$data['success']) {
                throw new \Exception($data['error'] ?? 'Lỗi định dạng dữ liệu trả về từ AI.');
            }

            if (!isset($data['data'])) {
                Log::error('MarketAnalysisController: Missing data key in analysis result', ['data' => $data]);
                throw new \Exception('Không nhận được kết quả phân tích từ AI. Vui lòng kiểm tra lại cấu hình.');
            }

        // Save analysis to database
        $product = \App\Models\Dashboard\AudienceConfig\Product::find($attributes['product_id']);
        $analysis_title = $this->marketAnalysisService->generateAnalysisTitle($type, $product);
        $analysis_summary = $this->marketAnalysisService->generateAnalysisSummary($type, $data['data']);

        $marketResearch = $this->marketAnalysisService->create([
            'product_id' => $attributes['product_id'],
            'research_type' => $type,
            'start_date' => $attributes['start_date'] ?? now()->toDateString(),
            'end_date' => $attributes['end_date'] ?? now()->addMonth()->toDateString(),
            'status' => 'completed',
            'title' => $analysis_title,
            'summary' => $analysis_summary,
            'analysis_data' => json_encode($data, JSON_UNESCAPED_UNICODE),
            'analysis_prompt' => null, // Can be added later if needed
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $data['data'],
                'type' => $type,
                'analysis_id' => $marketResearch->id,
                'message' => __('dashboard.analyze_market_success')
            ]);
        }
        } catch (ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => __('dashboard.validation_error') . ' ' . implode(', ', $e->validator->errors()->all()),
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
                    'message' => __('dashboard.analyze_market_fail')
                ], 500);
            }

            throw $e;
        }
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

    public function export($type)
    {
        try {
            // Get analysis data from session (stored when analysis was done)
            $analysisData = session('market_analysis_data');
            $productId = session('market_analysis_product_id');

            if (!$analysisData || !$productId) {
                return back()->with('toast-error', __('dashboard.no_analysis_data'));
            }

            $product = \App\Models\Dashboard\AudienceConfig\Product::find($productId);
            if (!$product) {
                return back()->with('toast-error', __('dashboard.product_not_found'));
            }

            return $this->marketAnalysisService->exportReport($type, $analysisData, $product);
        } catch (\Exception $e) {
            Log::error('Lỗi xuất báo cáo phân tích thị trường:', [
                'type' => $type,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Xử lý lỗi cụ thể cho ZipArchive
            if (strpos($e->getMessage(), 'ZipArchive') !== false) {
                return back()->with('toast-error', __('dashboard.ziparchive_missing'));
            }

            return back()->with('toast-error', __('dashboard.export_error_prefix') . ' ' . $e->getMessage());
        }
    }

    public function exportIndividual($id, $type)
    {
        try {
            $analysis = MarketResearch::whereHas('product', function ($query) {
                $query->where('user_id', Auth::id());
            })->findOrFail($id);
            $analysisData = $analysis->analysis_data;
            $product = $analysis->product;

            if (!$product) {
                return back()->with('toast-error', __('dashboard.product_not_found'));
            }

            return $this->marketAnalysisService->exportReport($type, ['data' => $analysisData], $product);
        } catch (\Exception $e) {
            Log::error('Lỗi xuất báo cáo phân tích thị trường từ database:', [
                'id' => $id,
                'type' => $type,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Xử lý lỗi cụ thể cho ZipArchive
            if (strpos($e->getMessage(), 'ZipArchive') !== false) {
                return back()->with('toast-error', __('dashboard.ziparchive_missing'));
            }

            return back()->with('toast-error', __('dashboard.export_error_prefix') . ' ' . $e->getMessage());
        }
    }

    public function renderPartial(Request $request, $type)
    {
        $data = json_decode($request->input('data'), true);
        
        if (!$data) {
            return response()->json(['data' => []]);
        }

        // The partial views expect ['data' => [...]] structure
        return view("dashboard.market_analysis.research.{$type}-analysis", ['data' => ['data' => $data]])->render();
    }
}
