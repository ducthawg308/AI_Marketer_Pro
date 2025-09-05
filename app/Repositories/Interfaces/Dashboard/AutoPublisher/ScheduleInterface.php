<?php

namespace App\Repositories\Interfaces\Dashboard\AutoPublisher;

use App\Repositories\RepositoryInterface;

interface ScheduleInterface extends RepositoryInterface
{
    /**
     * Hàm này xử lý tìm kiếm
     */
    public function search($search);
}