<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleHasPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();

        if ($adminRole) {
            $allPermissions = Permission::all();

            $adminRole->syncPermissions($allPermissions);

            $this->command->info('Admin role đã được gán ' . $allPermissions->count() . ' permissions!');
        } else {
            $this->command->error('Role admin không tồn tại!');
        }
    }
}