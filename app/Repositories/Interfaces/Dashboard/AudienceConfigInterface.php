<?php

namespace App\Repositories\Interfaces\Dashboard;

use App\Repositories\RepositoryInterface;

interface AudienceConfigInterface extends RepositoryInterface
{
    /**
     * Hàm này xử lý tìm kiếm
     */
    public function search($search);
}