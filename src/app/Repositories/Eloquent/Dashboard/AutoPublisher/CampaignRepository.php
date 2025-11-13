<?php

namespace App\Repositories\Eloquent\Dashboard\AutoPublisher;

use App\Models\Dashboard\AutoPublisher\Campaign;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Dashboard\AutoPublisher\CampaignInterface;
use Illuminate\Support\Arr;

class CampaignRepository extends BaseRepository implements CampaignInterface
{
    public function getModel(): string
    {
        return Campaign::class;
    }

    /**
     * Hàm xử lý tìm kiếm dựa vào điều kiện tìm kiếm và trả về kết quả
     */
    public function search($search)
    {
        $query = $this->model->query();
        $query->when(Arr::exists($search, 'keyword') && ! empty($search['keyword']), function ($q) use ($search) {
            $keyword = trim($search['keyword']);

            return $q->where(function ($q2) use ($keyword) {
                return $q2->where('name', 'like', '%'.$keyword.'%');
            });
        });

        return $query->paginate(config('const.per_page'));
    }
}