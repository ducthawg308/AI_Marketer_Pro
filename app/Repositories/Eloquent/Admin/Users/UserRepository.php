<?php

namespace App\Repositories\Eloquent\Admin\Users;

use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Admin\Users\UserInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class UserRepository extends BaseRepository implements UserInterface
{
    public function getModel(): string
    {
        return User::class;
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