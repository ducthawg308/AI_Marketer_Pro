<?php

namespace App\Repositories\Interfaces\Dashboard\AutoPublisher;

use App\Repositories\RepositoryInterface;

interface CampaignInterface extends RepositoryInterface
{
    /**
     * Hàm này xử lý tìm kiếm
     */
    public function search($search);
}