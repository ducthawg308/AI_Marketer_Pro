<?php

namespace App\Repositories\Eloquent\Dashboard\MarketResearch;

use App\Models\Dashboard\MarketResearch\MarketReport;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Dashboard\MarketResearch\MarketResearchInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class MarketResearchRepository extends BaseRepository implements MarketResearchInterface
{
    public function getModel(): string
    {
        return MarketReport::class;
    }

    public function search($search)
    {
        $query = $this->model->query()
            ->with(['product'])
            ->where('user_id', Auth::id());

        // Keyword filter by Product name or industry
        $query->when(Arr::exists($search, 'keyword') && ! empty($search['keyword']), function ($q) use ($search) {
            $keyword = trim($search['keyword']);

            return $q->whereHas('product', function ($q2) use ($keyword) {
                return $q2->where('name', 'like', '%'.$keyword.'%')
                          ->orWhere('industry', 'like', '%'.$keyword.'%');
            });
        });

        // Current status filter Let's add it in
        $query->when(Arr::exists($search, 'status') && ! empty($search['status']), function ($q) use ($search) {
            return $q->where('status', $search['status']);
        });

        // Filter by specific product ID
        $query->when(Arr::exists($search, 'product_id') && ! empty($search['product_id']), function ($q) use ($search) {
            return $q->where('product_id', $search['product_id']);
        });

        $query->orderBy('created_at', 'desc');

        return $query->paginate(config('const.per_page'));
    }

    public function findByProductId($productId)
    {
        return $this->model->where('product_id', $productId)
            ->where('user_id', Auth::id())
            ->first();
    }
}
