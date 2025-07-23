<?php

namespace App\Repositories\Interfaces\Dashboard;

use App\Repositories\RepositoryInterface;

interface AiCreatorInterface extends RepositoryInterface
{
    /**
     * Hàm này xử lý tìm kiếm
     */
    public function search($search);

    public function updateSettingByUserId(int $userId, array $data);
    
    public function getSettingByUserId(int $userId);
}