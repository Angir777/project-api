<?php

namespace Database\Seeders;

use Database\Seeders\Auth\PermissionsTableSeeder;
use Database\Seeders\Auth\RandomUsersSeeder;
use Database\Seeders\Auth\RolesTableSeeder;
use Illuminate\Database\Seeder;

class FakerDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Wywołanie seedera od uprawnień
        $this->call(PermissionsTableSeeder::class);

        // Wywołanie seedera od ról
        $this->call(RolesTableSeeder::class);

        // Wywołanie seedera od generowania randomowych userów
        $this->call(RandomUsersSeeder::class);
    }
}
