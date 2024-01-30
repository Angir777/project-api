<?php

namespace Database\Seeders\Auth;

use App\Enums\Auth\PermissionNamesEnum;
use App\Models\Auth\Permission;
use App\Models\Role\Role;
use Illuminate\Database\Seeder;

/**
 * Class RolesTableSeeder
 */
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // SUPERADMIN
        $superadminRole = Role::where('name', '=', config('access.roles.super_admin_role'))->first();
        if ($superadminRole == null) {
            // Utworzenie roli 'SUPER_ADMIN'
            $superadminRole = Role::create([
                'name' => config('access.roles.super_admin_role'),
                'guard_name' => config('access.default_guard_name'),
            ]);
            // Powiązanie roli 'SUPER_ADMIN' ze wszystkimi uprawnieniemi na start
            $superadminRole->givePermissionTo(Permission::all());
        }

        // ADMIN
        $adminRole = Role::where('name', '=', config('access.roles.admin_role'))->first();
        if ($adminRole == null) {
            // Utworzenie roli 'ADMIN'
            $adminRole = Role::create([
                'name' => config('access.roles.admin_role'),
                'guard_name' => config('access.default_guard_name'),
            ]);
            // Powiązanie roli 'ADMIN' z wybranymi uprawnieniemi na start
            $permissionsForAdmin = [
                PermissionNamesEnum::ADMIN,
                PermissionNamesEnum::USER,
                PermissionNamesEnum::USER_ACCESS,
                PermissionNamesEnum::USER_MANAGE,
                PermissionNamesEnum::PERMISSION_ACCESS,
            ];
            $permissions = Permission::whereIn('name', $permissionsForAdmin)->get();
            if ($permissions) {
                foreach ($permissions as $permission) {
                    $adminRole->givePermissionTo($permission);
                }
            }
        }

        // USER
        $userRole = Role::where('name', '=', config('access.roles.user_role'))->first();
        if ($userRole == null) {
            // Utworzenie roli 'USER'
            $userRole = Role::create([
                'name' => config('access.roles.user_role'),
                'guard_name' => config('access.default_guard_name'),
            ]);
            // Powiązanie roli 'USER' z wybranymi uprawnieniemi na start
            $permissionsForForemen = [
                PermissionNamesEnum::USER,
            ];
            $permissions = Permission::whereIn('name', $permissionsForForemen)->get();
            if ($permissions) {
                foreach ($permissions as $permission) {
                    $userRole->givePermissionTo($permission);
                }
            }
        }
    }
}
