<?php

namespace App\Services\Dashboard;

use App\Repositories\Interfaces\Dashboard\AiCreatorInterface;
use App\Services\BaseService;

class AiCreatorService extends BaseService
{
    public function __construct(private AiCreatorInterface $aiCreatorRepository) {}

    public function create($attributes)
    {
        return $this->aiCreatorRepository->create($attributes);
    }

    public function update($id, $attributes)
    {
        return $this->aiCreatorRepository->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->aiCreatorRepository->delete($id);
    }

    public function find($id)
    {
        return $this->aiCreatorRepository->find($id);
    }

    public function get($conditions = [])
    {
        return $this->aiCreatorRepository->get($conditions);
    }

    public function search($search)
    {
        $search = array_filter($search, fn ($value) => ! is_null($value) && $value !== '');

        return $this->aiCreatorRepository->search($search);
    }

    public function updateSetting(int $userId, array $data)
    {
        return $this->aiCreatorRepository->updateSettingByUserId($userId, $data);
    }

    public function getSetting(int $userId)
    {
        return $this->aiCreatorRepository->getSettingByUserId($userId);
    }

}