<?php

namespace App\Repositories\Interfaces\Admin\Users;

use App\Models\User;
use App\Repositories\Eloquent\Admin\Users\UserRepository;
use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserInterface extends RepositoryInterface
{
    /**
     * Search users with filters
     *
     * @param array $attributes
     * @param array $columns
     * @return LengthAwarePaginator
     */
    public function search(array $attributes, array $columns = ['*']): LengthAwarePaginator;

    /**
     * Filter by role
     *
     * @param string $role
     * @return UserRepository
     */
    public function setRole(string $role): UserRepository;

    /**
     * Get all active users
     *
     * @return Collection
     */
    public function getAllUser(): Collection;

    /**
     * Get user by remember token
     *
     * @param string $token
     * @param array $columns
     * @return User|null
     */
    public function getUserByToken(string $token, array $columns = ['*']): ?User;

    /**
     * Update user info by token
     *
     * @param array $attributes
     * @param string $token
     * @return User|null
     */
    public function updateInfo(array $attributes, string $token): ?User;

    /**
     * Get user by conditions
     *
     * @param array $conditions
     * @return User|null
     */
    public function getByConditions(array $conditions): ?User;

    /**
     * Update user password by token
     *
     * @param array $attributes
     * @param string $token
     * @return bool
     */
    public function userUpdatePassword(array $attributes, string $token): bool;

    /**
     * Update or create user data
     *
     * @param int $userId
     * @param array $data
     * @return User
     */
    public function updateOrCreate(int $userId, array $data): User;

    /**
     * Get user data by id
     *
     * @param int $userId
     * @param array $columns
     * @return User|null
     */
    public function getDataUserById(int $userId, array $columns = ['*']): ?User;

    /**
     * Get user detail by email
     *
     * @param array $param
     * @return User|null
     */
    public function getDetail(array $param): ?User;

    /**
     * Get user with roles and permissions
     *
     * @param int $userId
     * @return User|null
     */
    public function getUserWithRolesAndPermissions(int $userId): ?User;

    /**
     * Get users by role name
     *
     * @param string $roleName
     * @return Collection
     */
    public function getUsersByRole(string $roleName): Collection;

    /**
     * Get users by permission name
     *
     * @param string $permissionName
     * @return Collection
     */
    public function getUsersByPermission(string $permissionName): Collection;
}