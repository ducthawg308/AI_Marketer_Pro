<?php

namespace App\Repositories\Eloquent\Admin\Users;

use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Admin\Users\UserInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository extends BaseRepository implements UserInterface
{
    /**
     * Get Model
     *
     * @return string
     */
    public function getModel(): string
    {
        return User::class;
    }

    /**
     * Filter by role column
     *
     * @param string $role
     * @return UserRepository
     */
    public function setRole(string $role): UserRepository
    {
        $this->model = $this->model->where('role', $role);

        return $this;
    }

    /**
     * Search users with keyword filter
     *
     * @param array $attributes
     * @param array $columns
     * @return LengthAwarePaginator
     */
    public function search(array $attributes = [], array $columns = ['*']): LengthAwarePaginator
    {
        $keyword = $attributes['keyword'] ?? '';
        $role = $attributes['role'] ?? '';

        return $this->model->query()
            ->when(!empty($keyword), function ($query) use ($keyword) {
                return $query->where(function ($queryUser) use ($keyword) {
                    return $queryUser->where('name', 'LIKE', "%$keyword%")
                        ->orWhere('email', 'like', "%$keyword%");
                });
            })
            ->when(!empty($role), function ($query) use ($role) {
                return $query->where('role', $role);
            })
            ->orderBy('updated_at', 'DESC')
            ->orderBy('id', 'DESC')
            ->select($columns)
            ->paginate($this->perPage);
    }

    /**
     * Get all active users
     *
     * @return Collection
     */
    public function getAllUser(): Collection
    {
        return $this->model->select(['id', 'name', 'email'])
            ->whereNotNull('email_verified_at')
            ->get();
    }

    /**
     * Get user by remember token
     *
     * @param string $token
     * @param array $columns
     * @return User|null
     */
    public function getUserByToken(string $token, array $columns = ['*']): ?User
    {
        return $this->model->where('remember_token', $token)
            ->select($columns)
            ->first();
    }

    /**
     * Update user info by token
     *
     * @param array $attributes
     * @param string $token
     * @return User|null
     */
    public function updateInfo(array $attributes, string $token): ?User
    {
        $user = $this->getUserByToken($token);
        
        if (!$user) {
            return null;
        }

        $user->update($attributes);
        
        return $user;
    }

    /**
     * Get user by conditions
     *
     * @param array $conditions
     * @return User|null
     */
    public function getByConditions(array $conditions): ?User
    {
        return $this->model->where($conditions)->first();
    }

    /**
     * Update user password by token
     *
     * @param array $attributes
     * @param string $token
     * @return bool
     */
    public function userUpdatePassword(array $attributes, string $token): bool
    {
        $user = $this->getUserByToken($token);
        
        if ($user == null) {
            return false;
        }

        return $user->update($attributes);
    }

    /**
     * Update or create user data
     *
     * @param int $userId
     * @param array $data
     * @return User
     */
    public function updateOrCreate(int $userId, array $data): User
    {
        $where = ['id' => $userId];

        return $this->model->updateOrCreate($where, $data);
    }

    /**
     * Get user data by id
     *
     * @param int $userId
     * @param array $columns
     * @return User|null
     */
    public function getDataUserById(int $userId, array $columns = ['*']): ?User
    {
        return $this->model->where('id', $userId)->select($columns)->first();
    }

    /**
     * Get user detail by email
     *
     * @param array $param
     * @return User|null
     */
    public function getDetail(array $param = []): ?User
    {
        return $this->model->where('email', $param['email'])->first();
    }

    /**
     * Get user with roles and permissions (Laravel Permission)
     *
     * @param int $userId
     * @return User|null
     */
    public function getUserWithRolesAndPermissions(int $userId): ?User
    {
        return $this->model->with(['roles', 'permissions'])
            ->where('id', $userId)
            ->first();
    }

    /**
     * Get users by role name (Laravel Permission)
     *
     * @param string $roleName
     * @return Collection
     */
    public function getUsersByRole(string $roleName): Collection
    {
        return $this->model->role($roleName)->get();
    }

    /**
     * Get users by permission name (Laravel Permission)
     *
     * @param string $permissionName
     * @return Collection
     */
    public function getUsersByPermission(string $permissionName): Collection
    {
        return $this->model->permission($permissionName)->get();
    }
}