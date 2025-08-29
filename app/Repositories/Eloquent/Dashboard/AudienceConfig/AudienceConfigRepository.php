<?php

namespace App\Repositories\Eloquent\Dashboard\AudienceConfig;

use App\Models\Dashboard\AudienceConfig\Product;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Dashboard\AudienceConfig\AudienceConfigInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class AudienceConfigRepository extends BaseRepository implements AudienceConfigInterface
{
    public function getModel(): string
    {
        return Product::class;
    }

    /**
     * Hàm xử lý tìm kiếm dựa vào điều kiện tìm kiếm và trả về kết quả
     */
    public function search($search)
    {
        $query = $this->model->query();
        $query->where('user_id', Auth::id());
        $query->when(Arr::exists($search, 'keyword') && ! empty($search['keyword']), function ($q) use ($search) {
            $keyword = trim($search['keyword']);

            return $q->where(function ($q2) use ($keyword) {
                return $q2->where('name', 'like', '%'.$keyword.'%');
            });
        });

        return $query->paginate(config('const.per_page'));
    }
}