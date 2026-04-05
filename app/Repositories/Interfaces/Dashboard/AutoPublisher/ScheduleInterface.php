<?php

namespace App\Repositories\Interfaces\Dashboard\AutoPublisher;

use App\Repositories\RepositoryInterface;

interface ScheduleInterface extends RepositoryInterface
{
    /**
     * Hàm này xử lý tìm kiếm
     */
    public function search($search);

    /**
     * Tìm bản ghi kèm các quan hệ
     */
    public function findWithRelations($id, array $relations = []);
}