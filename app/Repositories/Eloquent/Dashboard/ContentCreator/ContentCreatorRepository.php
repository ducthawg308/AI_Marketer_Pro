<?php

namespace App\Repositories\Eloquent\Dashboard\ContentCreator;

use App\Models\Dashboard\ContentCreator\Ad;
use App\Models\Dashboard\ContentCreator\AiSetting;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Dashboard\ContentCreator\ContentCreatorInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class ContentCreatorRepository extends BaseRepository implements ContentCreatorInterface
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
    
    public function create($attributes = []): mixed
    {
        $type = $attributes['type'] ?? 'manual';

        switch ($type) {
            case 'product':
                if (!isset($attributes['product_id'], $attributes['ad_title'], $attributes['ad_content'])) {
                    throw new \InvalidArgumentException('Thiếu các trường bắt buộc cho type=product: product_id, ad_title, ad_content');
                }
                break;

            case 'link':
                if (!isset($attributes['link'], $attributes['ad_title'], $attributes['ad_content'])) {
                    throw new \InvalidArgumentException('Thiếu các trường bắt buộc cho type=link: link, ad_title, ad_content');
                }
                break;

            case 'manual':
            default:
                if (!isset($attributes['ad_title'], $attributes['ad_content'])) {
                    throw new \InvalidArgumentException('Thiếu các trường bắt buộc cho type=manual: ad_title, ad_content');
                }
                break;
        }

        $data = array_merge([
            'user_id'    => Auth::id(),
            'status'     => 'draft',
            'created_at' => now(),
            'updated_at' => now(),
            'hashtags'   => null,
            'emojis'     => null,
            'product_id' => null,
            'link'       => null,
        ], $attributes);

        return $this->model->create($data);
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