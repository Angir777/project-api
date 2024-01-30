<?php

namespace Database\Seeders\Auth;

use Database\Seeders\Auth\PermissionsByGroup\AdministrationPermissionsSeeder;
use Database\Seeders\Auth\PermissionsByGroup\GeneralPermissionsSeeder;
use Illuminate\Database\Seeder;

/**
 * Class PermissionsTableSeeder
 */
class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GeneralPermissionsSeeder::class);
        $this->call(AdministrationPermissionsSeeder::class);
    }
}
