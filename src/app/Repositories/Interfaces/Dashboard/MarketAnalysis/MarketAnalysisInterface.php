<?php

namespace App\Repositories\Interfaces\Dashboard\MarketAnalysis;

use App\Repositories\RepositoryInterface;

interface MarketAnalysisInterface extends RepositoryInterface
{
    /**
     * Hàm này xử lý tìm kiếm
     */
    public function search($search);
}