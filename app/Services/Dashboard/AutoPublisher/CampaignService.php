<?php

namespace App\Services\Dashboard\AutoPublisher;

use App\Repositories\Interfaces\Dashboard\AutoPublisher\CampaignInterface;
use App\Services\BaseService;

class CampaignService extends BaseService
{
    public function __construct(private CampaignInterface $campaignRepository) {}

    public function create($attributes)
    {
        return $this->campaignRepository->create($attributes);
    }

    public function update($id, $attributes)
    {
        return $this->campaignRepository->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->campaignRepository->delete($id);
    }

    public function find($id)
    {
        return $this->campaignRepository->find($id);
    }

    public function get($conditions = [])
    {
        return $this->campaignRepository->get($conditions);
    }

    public function search($search)
    {
        $search = array_filter($search, fn ($value) => ! is_null($value) && $value !== '');

        return $this->campaignRepository->search($search);
    }
}