<?php

namespace App\Repositories\Eloquent\Dashboard;

use App\Models\Dashboard\AiCreator\Ad;
use App\Models\Dashboard\AiCreator\AiSetting;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Dashboard\AiCreatorInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class AiCreatorRepository extends BaseRepository implements AiCreatorInterface
{
    public function getModel(): string
    {
        return Ad::class;
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
                return $q2->where('ad_title', 'like', '%'.$keyword.'%');
            });
        });

        return $query->paginate(config('const.per_page'));
    }

    public function updateSettingByUserId(int $userId, array $data)
    {
        $setting = AiSetting::where('user_id', $userId)->firstOrFail();
        $setting->update($data);
        return $setting;
    }

    public function getSettingByUserId(int $userId)
    {
        return AiSetting::where('user_id', $userId)->first();
    }
}