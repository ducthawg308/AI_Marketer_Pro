<?php

namespace App\Services\Dashboard\MarketResearch;

use App\Models\Dashboard\AudienceConfig\Product;
use App\Models\Dashboard\MarketResearch\MarketReport;
use App\Repositories\Interfaces\Dashboard\MarketResearch\MarketResearchInterface;
use App\Services\BaseService;
use App\Jobs\GenerateMarketReportJob;
use Illuminate\Support\Facades\Auth;

class MarketResearchService extends BaseService
{
    public function __construct(private MarketResearchInterface $marketResearchRepository) {}

    public function search($search)
    {
        $search = array_filter($search, fn ($value) => ! is_null($value) && $value !== '');
        return $this->marketResearchRepository->search($search);
    }

    public function findByProductId($productId)
    {
        return $this->marketResearchRepository->findByProductId($productId);
    }

    public function find($id)
    {
        return $this->marketResearchRepository->find($id);
    }

    public function delete($id)
    {
        return $this->marketResearchRepository->delete($id);
    }

    /**
     * Trigger new market research for a product
     */
    public function triggerResearch(Product $product)
    {
        // 1. Check if report already exists and is pending/processing
        $existingReport = $this->marketResearchRepository->findByProductId($product->id);
        
        if ($existingReport && in_array($existingReport->status, ['pending', 'collecting', 'analyzing', 'generating'])) {
            return [
                'success' => false,
                'message' => 'Nghiên cứu thị trường cho sản phẩm này đang được xử lý.',
                'report' => $existingReport
            ];
        }

        // 2. Refresh or Create new Report
        if ($existingReport) {
            $existingReport->update([
                'status' => 'pending',
                'current_step' => 'Đang đưa vào hàng đợi...',
                'progress_percent' => 0,
                'error_message' => null,
            ]);
            $report = $existingReport;
        } else {
            $report = $this->marketResearchRepository->create([
                'product_id' => $product->id,
                'user_id' => Auth::id(),
                'status' => 'pending',
                'current_step' => 'Đang đưa vào hàng đợi...',
                'progress_percent' => 0,
            ]);
        }

        // 3. Dispatch Job
        GenerateMarketReportJob::dispatch($product, $report->id);

        return [
            'success' => true,
            'message' => 'Hệ thống đang bắt đầu nghiên cứu thị trường...',
            'report' => $report
        ];
    }
}
