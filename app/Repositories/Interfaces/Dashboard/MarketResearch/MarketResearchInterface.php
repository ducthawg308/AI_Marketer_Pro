<?php

namespace App\Repositories\Interfaces\Dashboard\MarketResearch;

use App\Repositories\RepositoryInterface;

interface MarketResearchInterface extends RepositoryInterface
{
    // Tìm kiếm báo cáo
    public function search($search);
    
    // Tìm báo cáo theo product_id
    public function findByProductId($productId);
}
