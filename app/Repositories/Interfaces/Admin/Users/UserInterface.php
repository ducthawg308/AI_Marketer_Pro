<?php

namespace App\Repositories\Interfaces\Admin\Users;

use App\Repositories\RepositoryInterface;

interface UserInterface extends RepositoryInterface
{
    /**
     * Hàm này xử lý tìm kiếm
     */
    public function search($search);
}