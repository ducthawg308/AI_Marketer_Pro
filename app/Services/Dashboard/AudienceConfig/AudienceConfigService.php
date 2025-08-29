<?php

namespace App\Services\Dashboard\AudienceConfig;

use App\Repositories\Interfaces\Dashboard\AudienceConfig\AudienceConfigInterface;
use App\Services\BaseService;

class AudienceConfigService extends BaseService
{
    public function __construct(private AudienceConfigInterface $audienceConfigRepository) {}

    public function create($attributes)
    {
        return $this->audienceConfigRepository->create($attributes);
    }

    public function update($id, $attributes)
    {
        return $this->audienceConfigRepository->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->audienceConfigRepository->delete($id);
    }

    public function find($id)
    {
        return $this->audienceConfigRepository->find($id);
    }

    public function get($conditions = [])
    {
        return $this->audienceConfigRepository->get($conditions);
    }

    public function search($search)
    {
        $search = array_filter($search, fn ($value) => ! is_null($value) && $value !== '');

        return $this->audienceConfigRepository->search($search);
    }
}