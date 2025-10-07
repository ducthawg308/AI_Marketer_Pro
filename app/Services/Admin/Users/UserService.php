<?php

namespace App\Services\Admin\Users;

use App\Repositories\Interfaces\Admin\Users\UserInterface;
use App\Services\BaseService;

class UserService extends BaseService
{
    public function __construct(private UserInterface $userRepository) {}

    public function create($attributes)
    {
        return $this->userRepository->create($attributes);
    }

    public function update($id, $attributes)
    {
        return $this->userRepository->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->userRepository->delete($id);
    }

    public function find($id)
    {
        return $this->userRepository->find($id);
    }

    public function get($conditions = [])
    {
        return $this->userRepository->get($conditions);
    }

    public function search($search)
    {
        $search = array_filter($search, fn ($value) => ! is_null($value) && $value !== '');

        return $this->userRepository->search($search);
    }
}