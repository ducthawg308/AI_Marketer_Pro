<?php

namespace App\Services\Dashboard;

use App\Repositories\Interfaces\Dashboard\AutopublisherInterface;
use App\Services\BaseService;

class AutopublisherService extends BaseService
{
    public function __construct(private AutopublisherInterface $autopublisherRepository) {}

    public function create($attributes)
    {
        return $this->autopublisherRepository->create($attributes);
    }

    public function update($id, $attributes)
    {
        return $this->autopublisherRepository->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->autopublisherRepository->delete($id);
    }

    public function find($id)
    {
        return $this->autopublisherRepository->find($id);
    }

    public function get($conditions = [])
    {
        return $this->autopublisherRepository->get($conditions);
    }

    public function search($search)
    {
        $search = array_filter($search, fn ($value) => ! is_null($value) && $value !== '');

        return $this->autopublisherRepository->search($search);
    }
}