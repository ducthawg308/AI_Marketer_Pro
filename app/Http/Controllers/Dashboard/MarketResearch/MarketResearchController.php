<?php

namespace App\Http\Controllers\Dashboard\MarketResearch;

use App\Http\Controllers\Controller;
use App\Models\Dashboard\AudienceConfig\Product;
use App\Services\Dashboard\MarketResearch\MarketResearchService;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class MarketResearchController extends Controller
{
    private $marketResearchService;

    public function __construct(MarketResearchService $marketResearchService)
    {
        $this->marketResearchService = $marketResearchService;
    }

    public function index(Request $request)
    {
        $search = $request->only(['keyword', 'status']);
        $items = $this->marketResearchService->search($search);

        return view('dashboard.market_research.index', compact('items', 'search'));
    }

    public function trigger(Request $request, Product $product)
    {
        if ($product->user_id !== auth()->id()) {
            abort(403);
        }

        $result = $this->marketResearchService->triggerResearch($product);

        if ($result['success']) {
            return redirect()->route('dashboard.market_research.show', $result['report']->id)
                ->with('toast-success', $result['message']);
        }

        return back()->with('toast-error', $result['message']);
    }

    public function show($id)
    {
        $report = $this->marketResearchService->find($id);

        if (!$report || $report->user_id !== auth()->id()) {
            abort(404);
        }

        // Return view for dashboard
        return view('dashboard.market_research.show', compact('report'));
    }

    public function status($id)
    {
        $report = $this->marketResearchService->find($id);

        if (!$report || $report->user_id !== auth()->id()) {
            return response()->json(['error' => 'Not found'], 404);
        }

        return response()->json([
            'status' => $report->status,
            'progress_percent' => $report->progress_percent,
            'current_step' => $report->current_step,
            'completed_at' => $report->completed_at ? $report->completed_at->diffForHumans() : null,
        ]);
    }

    public function exportPdf($id)
    {
        $report = $this->marketResearchService->find($id);
        if (!$report || $report->status !== 'completed' || $report->user_id !== auth()->id()) {
            abort(404);
        }

        $html = view('dashboard.market_research.export_pdf', compact('report'))->render();
        
        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $options->set('isRemoteEnabled', true);
        
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream("Market_Research_{$report->product->name}.pdf");
    }

    public function exportWord($id)
    {
        $report = $this->marketResearchService->find($id);
        if (!$report || $report->status !== 'completed' || $report->user_id !== auth()->id()) {
            abort(404);
        }

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        $section->addText("Báo cáo Nghiên Cứu Thị Trường: {$report->product->name}", ['bold' => true, 'size' => 16]);
        $section->addTextBreak();
        
        if (isset($report->qualitative_analysis['executive_summary'])) {
            $section->addText("1. Tóm tắt chiến lược", ['bold' => true, 'size' => 14]);
            $section->addText($report->qualitative_analysis['executive_summary']);
            $section->addTextBreak();
        }

        // SWot
        if (isset($report->qualitative_analysis['swot_analysis'])) {
             $section->addText("2. Phân tích SWOT", ['bold' => true, 'size' => 14]);
             $swot = $report->qualitative_analysis['swot_analysis'];
             $section->addText("Điểm mạnh (Strengths):", ['bold' => true]);
             foreach($swot['strengths'] ?? [] as $s) $section->addListItem($s);
             $section->addText("Điểm yếu (Weaknesses):", ['bold' => true]);
             foreach($swot['weaknesses'] ?? [] as $w) $section->addListItem($w);
             $section->addText("Cơ hội (Opportunities):", ['bold' => true]);
             foreach($swot['opportunities'] ?? [] as $o) $section->addListItem($o);
             $section->addText("Thách thức (Threats):", ['bold' => true]);
             foreach($swot['threats'] ?? [] as $t) $section->addListItem($t);
             $section->addTextBreak();
        }

        // Action plan
        if (isset($report->qualitative_analysis['action_plan'])) {
            $section->addText("3. Kế hoạch hành động 90 ngày", ['bold' => true, 'size' => 14]);
            $ap = $report->qualitative_analysis['action_plan'];
            $section->addText("Giai đoạn 1 (30 ngày):", ['bold' => true]);
            foreach($ap['phase_1_30_days'] ?? [] as $p) $section->addListItem($p);
            $section->addText("Giai đoạn 2 (60 ngày):", ['bold' => true]);
            foreach($ap['phase_2_60_days'] ?? [] as $p) $section->addListItem($p);
            $section->addText("Giai đoạn 3 (90 ngày):", ['bold' => true]);
            foreach($ap['phase_3_90_days'] ?? [] as $p) $section->addListItem($p);
        }

        $filename = "MarketResearch_{$report->id}.docx";
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment; filename="'. $filename . '"');
        $objWriter->save("php://output");
        exit;
    }

    public function destroy($id)
    {
        $isDestroy = $this->marketResearchService->delete($id);

        return $isDestroy
            ? redirect()->route('dashboard.market_research.index')->with('toast-success', 'Đã xoá báo cáo thành công.')
            : back()->with('toast-error', 'Có lỗi khi xoá báo cáo.');
    }
}
