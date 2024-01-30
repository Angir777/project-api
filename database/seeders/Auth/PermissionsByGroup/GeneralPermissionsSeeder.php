<?php

namespace Database\Seeders\Auth\PermissionsByGroup;

use App\Enums\Auth\PermissionGroupsNamesEnum;
use App\Enums\Auth\PermissionNamesEnum;
use App\Models\Auth\Permission;
use App\Models\Auth\PermissionGroup;
use Illuminate\Database\Seeder;

/**
 * Class GeneralPermissionsSeeder
 */
class GeneralPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $generalGroup = PermissionGroup::where('name', 'like', PermissionGroupsNamesEnum::GENERAL)->first();

        if ($generalGroup == null)
        {
            $generalGroup = PermissionGroup::create([
                'name' => PermissionGroupsNamesEnum::GENERAL
            ]);
        }

        // Tablica zawierajaca wszystkie uprawnienia z danej grupy
        $generalPermissions = array(
            PermissionNamesEnum::USER,
        );

        // utworzenie uprawnien o ile nie istnieja
        foreach ($generalPermissions as $permission) {
            if (Permission::where('name', 'like', $permission)->first() == null)
            {
                Permission::create([
                    'name' => $permission,
                    'guard_name' => config('access.default_guard_name'),
                    'permission_group_id' => $generalGroup->id
                ]);
            }
        }
    }
}
