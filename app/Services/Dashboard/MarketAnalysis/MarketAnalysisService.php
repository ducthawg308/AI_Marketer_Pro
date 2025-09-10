<?php

namespace App\Services\Dashboard\MarketAnalysis;

use App\Repositories\Interfaces\Dashboard\MarketAnalysis\MarketAnalysisInterface;
use App\Services\BaseService;

class MarketAnalysisService extends BaseService
{
    public function __construct(private MarketAnalysisInterface $marketAnalysisRepository) {}

    public function create($attributes)
    {
        return $this->marketAnalysisRepository->create($attributes);
    }

    public function update($id, $attributes)
    {
        return $this->marketAnalysisRepository->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->marketAnalysisRepository->delete($id);
    }

    public function find($id)
    {
        return $this->marketAnalysisRepository->find($id);
    }

    public function get($conditions = [])
    {
        return $this->marketAnalysisRepository->get($conditions);
    }

    public function search($search)
    {
        $search = array_filter($search, fn ($value) => ! is_null($value) && $value !== '');

        return $this->marketAnalysisRepository->search($search);
    }
}