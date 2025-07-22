<?php

namespace App\Services\Dashboard;

use App\Models\Dashboard\AudienceConfig\Competitor;
use App\Models\Dashboard\AudienceConfig\Product;
use App\Models\Dashboard\AudienceConfig\TargetCustomer;
use App\Repositories\Interfaces\Dashboard\AudienceConfigInterface;
use App\Services\BaseService;

class AudienceConfigService extends BaseService
{
    public function __construct(private AudienceConfigInterface $audienceconfigRepository) {}

    public function create(array $attributes)
    {
        // Lưu sản phẩm
        $product = Product::create([
            'name' => $attributes['name'],
            'industry' => $attributes['industry'],
            'description' => $attributes['description'] ?? null,
            'user_id' => auth()->id(),
        ]);

        // Lưu khách hàng mục tiêu
        $product->targetCustomers()->create([
            'age_range' => $attributes['age_range'] ?? null,
            'income_level' => $attributes['income_level'] ?? null,
            'interests' => $attributes['interests'] ?? null,
        ]);

        // Lưu đối thủ cạnh tranh (nếu có)
        if (!empty($attributes['competitor_name']) || !empty($attributes['competitor_url']) || !empty($attributes['competitor_description'])) {
            $product->competitors()->create([
                'name' => $attributes['competitor_name'] ?? null,
                'url' => $attributes['competitor_url'] ?? null,
                'description' => $attributes['competitor_description'] ?? null,
            ]);
        }

        return $product;
    }

    public function update($id, array $attributes)
    {
        $product = Product::find($id);
        if (!$product) {
            return false;
        }

        // Cập nhật sản phẩm
        $product->update([
            'name' => $attributes['name'],
            'industry' => $attributes['industry'],
            'description' => $attributes['description'] ?? null,
        ]);

        // Cập nhật hoặc tạo mới khách hàng mục tiêu
        $targetCustomer = $product->targetCustomers()->first();
        if ($targetCustomer) {
            $targetCustomer->update([
                'age_range' => $attributes['age_range'] ?? null,
                'income_level' => $attributes['income_level'] ?? null,
                'interests' => $attributes['interests'] ?? null,
            ]);
        } else {
            $product->targetCustomers()->create([
                'age_range' => $attributes['age_range'] ?? null,
                'income_level' => $attributes['income_level'] ?? null,
                'interests' => $attributes['interests'] ?? null,
            ]);
        }

        // Cập nhật hoặc tạo mới đối thủ cạnh tranh
        $competitor = $product->competitors()->first();
        if (!empty($attributes['competitor_name']) || !empty($attributes['competitor_url']) || !empty($attributes['competitor_description'])) {
            if ($competitor) {
                $competitor->update([
                    'name' => $attributes['competitor_name'] ?? null,
                    'url' => $attributes['competitor_url'] ?? null,
                    'description' => $attributes['competitor_description'] ?? null,
                ]);
            } else {
                $product->competitors()->create([
                    'name' => $attributes['competitor_name'] ?? null,
                    'url' => $attributes['competitor_url'] ?? null,
                    'description' => $attributes['competitor_description'] ?? null,
                ]);
            }
        } elseif ($competitor) {
            $competitor->delete(); // Xóa đối thủ nếu không có dữ liệu mới
        }

        return $product;
    }

    public function delete($id)
    {
        return $this->audienceconfigRepository->delete($id);
    }

    public function find($id)
    {
        return $this->audienceconfigRepository->find($id);
    }

    public function get($conditions = [])
    {
        return $this->audienceconfigRepository->get($conditions);
    }

    public function search($search)
    {
        $search = array_filter($search, fn ($value) => !is_null($value) && $value !== '');
        return $this->audienceconfigRepository->search($search);
    }
}