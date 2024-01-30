<?php

namespace Database\Seeders\Auth\PermissionsByGroup;

use App\Enums\Auth\PermissionGroupsNamesEnum;
use App\Enums\Auth\PermissionNamesEnum;
use App\Models\Auth\Permission;
use App\Models\Auth\PermissionGroup;
use Illuminate\Database\Seeder;

/**
 * Class AdministrationPermissionsSeeder
 */
class AdministrationPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $administrationGroup = PermissionGroup::where('name', 'like', PermissionGroupsNamesEnum::ADMINISTRATION)->first();

        if ($administrationGroup == null)
        {
            $administrationGroup = PermissionGroup::create([
                'name' => PermissionGroupsNamesEnum::ADMINISTRATION
            ]);
        }

        // Tablica zawierajaca wszystkie uprawnienia z danej grupy
        $administrationPermissions = array(
            PermissionNamesEnum::SUPER_ADMIN,
            PermissionNamesEnum::ADMIN,
            PermissionNamesEnum::USER,
            PermissionNamesEnum::PERMISSION_ACCESS,
            PermissionNamesEnum::ROLE_ACCESS,
            PermissionNamesEnum::ROLE_MANAGE,
            PermissionNamesEnum::USER_ACCESS,
            PermissionNamesEnum::USER_MANAGE,
        );

        // Utworzenie uprawnien o ile nie istnieja
        foreach ($administrationPermissions as $permission) {
            if (Permission::where('name', 'like', $permission)->first() == null)
            {
                Permission::create([
                    'name' => $permission,
                    'guard_name' => config('access.default_guard_name'),
                    'permission_group_id' => $administrationGroup->id
                ]);
            }
        }
    }
}
