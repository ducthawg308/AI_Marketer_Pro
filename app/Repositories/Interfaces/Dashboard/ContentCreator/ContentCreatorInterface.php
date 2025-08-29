<?php

namespace App\Repositories\Interfaces\Dashboard\ContentCreator;

use App\Repositories\RepositoryInterface;

interface ContentCreatorInterface extends RepositoryInterface
{
    /**
     * Hàm này xử lý tìm kiếm
     */
    public function search($search);

    public function updateSettingByUserId(int $userId, array $data);
    
    public function getSettingByUserId(int $userId);
}