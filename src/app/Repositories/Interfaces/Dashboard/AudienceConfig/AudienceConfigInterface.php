<?php

namespace App\Repositories\Interfaces\Dashboard\AudienceConfig;

use App\Repositories\RepositoryInterface;

interface AudienceConfigInterface extends RepositoryInterface
{
    /**
     * Hàm này xử lý tìm kiếm
     */
    public function search($search);
}