<?php

namespace App\Services\Admin\Users;

use App\Models\User;
use App\Repositories\Interfaces\Admin\Users\UserInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class UserService
{
    /**
     * The property repository
     */
    protected UserInterface $userRepository;

    /**
     * The constructor function
     */
    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * The function get info user by id
     */
    public function getInfoUserById(int $userId): mixed
    {
        $editInfoUser = $this->getUserTemporary();

        if (empty($editInfoUser)) {
            $editInfoUser = $this->userRepository->getDataUserById($userId);
        }

        $this->removeUserTemporary();

        return $editInfoUser;
    }

    /**
     * The function save session data edit
     *
     * @return array
     */
    public function saveTemporaryUser($attributes)
    {
        $this->saveUserTemporary($attributes);

        return $attributes;
    }

    /**
     * The function handle save data edit in database
     *
     * @return bool
     */
    public function saveDataUser()
    {
        $data = $this->getUserTemporary();
        $id = Auth::guard()->user()->id;
        $this->removeUserTemporary();

        return $this->userRepository->updateOrCreate($id, $data);
    }

    /**
     * The function helper get user temporary
     *
     * @return mixed
     */
    private function getUserTemporary()
    {
        return Session::get(config('const.sessionClient.editInfoUser'));
    }

    /**
     * The function save user temporary
     */
    private function saveUserTemporary($data): void
    {
        Session::put(config('const.sessionClient.editInfoUser'), $data);
    }

    /**
     * The function remove user temporary
     */
    private function removeUserTemporary(): void
    {
        Session::forget(config('const.sessionClient.editInfoUser'));
    }

    /**
     * The function update password of user.
     *
     * @return mixed
     */
    public function updatePassword($attributes, $token)
    {
        $updateData = [
            'password' => Hash::make($attributes['password']),
            'remember_token' => Str::random(60),
            'email_verified_at' => Carbon::now(),
        ];

        return $this->userRepository->userUpdatePassword($updateData, $token);
    }

    /**
     * Search users
     */
    public function search($search)
    {
        $search = array_filter($search, fn ($value) => ! is_null($value) && $value !== '');

        return $this->userRepository->search($search);
    }

    /**
     * Create new user with roles
     */
    public function create(array $attributes): User
    {
        return DB::transaction(function () use ($attributes) {
            $newUser = [
                'name' => $attributes['name'],
                'email' => $attributes['email'],
                'password' => Hash::make($attributes['password']),
                'role' => $attributes['role'] ?? 'user',
                'email_verified_at' => Carbon::now(),
            ];

            // Add optional fields if provided
            if (isset($attributes['google_id'])) {
                $newUser['google_id'] = $attributes['google_id'];
            }
            
            if (isset($attributes['facebook_id'])) {
                $newUser['facebook_id'] = $attributes['facebook_id'];
            }
            
            if (isset($attributes['facebook_access_token'])) {
                $newUser['facebook_access_token'] = $attributes['facebook_access_token'];
            }
            
            if (isset($attributes['facebook_token_expires_at'])) {
                $newUser['facebook_token_expires_at'] = $attributes['facebook_token_expires_at'];
            }

            $user = $this->userRepository->create($newUser);
            
            // Sync roles using Laravel Permission
            if (isset($attributes['roles'])) {
                $user->syncRoles($attributes['roles']);
            }
            
            // Sync permissions if provided
            if (isset($attributes['permissions'])) {
                $user->syncPermissions($attributes['permissions']);
            }

            return $user;
        });
    }

    /**
     * Update user with roles
     */
    public function update(int $userId, array $attributes): User
    {
        return DB::transaction(function () use ($userId, $attributes) {
            $updateUser = [
                'name' => $attributes['name'],
                'email' => $attributes['email'],
            ];

            // Update password if provided
            if (isset($attributes['password']) && !empty($attributes['password'])) {
                $updateUser['password'] = Hash::make($attributes['password']);
            }

            // Update optional fields if provided
            if (isset($attributes['google_id'])) {
                $updateUser['google_id'] = $attributes['google_id'];
            }
            
            if (isset($attributes['facebook_id'])) {
                $updateUser['facebook_id'] = $attributes['facebook_id'];
            }
            
            if (isset($attributes['facebook_access_token'])) {
                $updateUser['facebook_access_token'] = $attributes['facebook_access_token'];
            }
            
            if (isset($attributes['facebook_token_expires_at'])) {
                $updateUser['facebook_token_expires_at'] = $attributes['facebook_token_expires_at'];
            }

            $user = $this->userRepository->update($userId, $updateUser);
            
            // Sync roles using Laravel Permission
            if (isset($attributes['roles'])) {
                // Convert role IDs to Role models
                $roleModels = \Spatie\Permission\Models\Role::whereIn('id', $attributes['roles'])->get();
                $user->syncRoles($roleModels);
            } elseif (isset($attributes['role'])) {
                // Convert single role ID to Role model
                $roleModel = \Spatie\Permission\Models\Role::find($attributes['role']);
                if ($roleModel) {
                    $user->syncRoles([$roleModel]);
                }
            }
            
            // Sync permissions if provided
            if (isset($attributes['permissions'])) {
                $user->syncPermissions($attributes['permissions']);
            }

            return $user;
        });
    }

    /**
     * Delete user
     */
    public function delete(int $userId): bool
    {
        return $this->userRepository->delete($userId);
    }

    /**
     * Get user with roles and permissions
     */
    public function getUserWithRolesAndPermissions(int $userId): ?User
    {
        return $this->userRepository->getUserWithRolesAndPermissions($userId);
    }

    /**
     * Assign role to user
     */
    public function assignRole(int $userId, string|array $roles): User
    {
        $user = $this->userRepository->find($userId);
        $user->assignRole($roles);
        
        return $user;
    }

    /**
     * Remove role from user
     */
    public function removeRole(int $userId, string|array $roles): User
    {
        $user = $this->userRepository->find($userId);
        $user->removeRole($roles);
        
        return $user;
    }

    /**
     * Assign permission to user
     */
    public function givePermission(int $userId, string|array $permissions): User
    {
        $user = $this->userRepository->find($userId);
        $user->givePermissionTo($permissions);
        
        return $user;
    }

    /**
     * Revoke permission from user
     */
    public function revokePermission(int $userId, string|array $permissions): User
    {
        $user = $this->userRepository->find($userId);
        $user->revokePermissionTo($permissions);
        
        return $user;
    }

    /**
     * Get all users
     */
    public function getAllUser()
    {
        return $this->userRepository->getAllUser();
    }

    /**
     * Get user by conditions
     */
    public function getByConditions(array $conditions)
    {
        return $this->userRepository->getByConditions($conditions);
    }

    /**
     * Get user detail
     */
    public function getDetail(array $param)
    {
        return $this->userRepository->getDetail($param);
    }

    /**
     * Get users by role
     */
    public function getUsersByRole(string $roleName)
    {
        return $this->userRepository->getUsersByRole($roleName);
    }

    /**
     * Get users by permission
     */
    public function getUsersByPermission(string $permissionName)
    {
        return $this->userRepository->getUsersByPermission($permissionName);
    }
}