<?php

namespace Database\Seeders;

use App\Models\Auth\Permission;
use App\Models\Role\Role;
use Database\Seeders\Auth\PermissionsTableSeeder;
use Illuminate\Database\Seeder;


class RefreshPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionsTableSeeder::class);

        // Przypisanie wszystkich ról do super admina
        $superAdminRole = Role::where('name', '=', config('access.roles.super_admin_role'))->first();
        if ($superAdminRole != null)
        {
            $superAdminRole->givePermissionTo(Permission::all());
        }
    }
}
