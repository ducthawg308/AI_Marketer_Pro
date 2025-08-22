<?php

namespace App\Repositories\Eloquent\Dashboard;

use App\Models\Dashboard\AutoPublisher\AdSchedule;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Dashboard\AutoPublisherInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class AutoPublisherRepository extends BaseRepository implements AutoPublisherInterface
{
    public function getModel(): string
    {
        return AdSchedule::class;
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
                return $q2->where('ten', 'like', '%'.$keyword.'%');
            });
        });

        return $query->paginate(config('const.per_page'));
    }
}