<?php

namespace Database\Seeders;

use App\Enums\Auth\PermissionGroupsNamesEnum;
use App\Enums\Auth\PermissionNamesEnum;
use App\Models\Auth\Permission;
use App\Models\Role\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefreshPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Command: 'sail composer refresh-permissions'
     *
     * @return void
     */
    public function run()
    {
        // Usuwamy z pamięci podręcznej klucz od uprawnień
        app()['cache']->forget('spatie.permission.cache');

        DB::transaction(function () {
            // Podstawowe grupy uprawnień
            $basicGroups = [
                PermissionGroupsNamesEnum::ADMINISTRATION, 
                PermissionGroupsNamesEnum::GENERAL
            ];

            // Pobranie aktualnych uprawnień, które są na bazie danych 
            // (oprócz uprawnień podstawowych których nie ruszamy)
            $actualPermissions = Permission::whereNotIn('permission_group_name', $basicGroups)->pluck('name')->toArray();

            /**
             * Dodatkowe uprawnienia dla nowych modułów
             * Należy dodać nową nazwę grupy do 'PermissionGroupsNamesEnum' oraz uprawnienia do 'PermissionNamesEnum'
             */

            // Uprawnienia dla nowej grupy
            // Jeśli grupa nie ma uprawnień (zostaną tutaj usunięte), to sama zostaje usunięta
            $newExampleGroupPermissions = array(
                PermissionNamesEnum::TEST_PERMISSION_ACCESS,
                PermissionNamesEnum::TEST_PERMISSION_MANAGE,
            );

            foreach ($newExampleGroupPermissions as $permission) {
                if (Permission::where('name', 'like', $permission)->first() == null) {
                    Permission::create([
                        'name' => $permission,
                        'guard_name' => 'web',
                        'permission_group_name' => PermissionGroupsNamesEnum::TEST_PERMISSION_GROUP
                    ]);
                }
            }
            // END NEW EXAMPLE MODULE

            /**
             * Koniec dodatkowych uprawnień dla nowych modułów
             */

            // Przypisanie wszystkich ról do super administratora
            $superAdminRole = Role::where('name', '=', config('access.roles.super_admin_role'))->first();
            if ($superAdminRole != null) {
                $superAdminRole->givePermissionTo(Permission::all());
            }

            // Określenie nowych uprawnień
            $newPermissions = [];
            $newPermissions = array_merge($newPermissions, $newExampleGroupPermissions); // newExample

            // Uprawnienia do usunięcia (te dodatkowe, których nie ma w tym pliku)
            $deletedPermissions = array_diff($actualPermissions, $newPermissions);
            if (count($deletedPermissions) !== 0) {
                foreach (Role::all() as $rola) {
                    // Odpinamy uprawnienie od roli
                    $rola->revokePermissionTo($deletedPermissions);
                    // Usuwamy powiązania związane z tą rolą w tabeli role_has_permissions
                    // UWAGA! Usunięte zostanie powiązanie roli z danym uprawnieniem, 
                    // czyli dana rola (użytkownik też jesli posiada tę rolę) już nie będzie miała tego danego uprawnienia
                    $rola->permissions()->detach(Permission::whereIn('name', $deletedPermissions)->pluck('id'));
                }
            }

            // Usunięcie uprawnień, które nie są używane
            foreach ($deletedPermissions as $deletedPermission) {
                $oldPermission = Permission::where('name', $deletedPermission)->first();
                // Usuwamy całkowicie uprawnienie
                $oldPermission?->forceDelete();
            }
        });
    }
}
