<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\Auth\PermissionsTableSeeder;
use Database\Seeders\Auth\RolesTableSeeder;
use Database\Seeders\Auth\UsersTableSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Wywołanie seedera od uprawnień
        $this->call(PermissionsTableSeeder::class);

        // Wywołanie seedera od ról
        $this->call(RolesTableSeeder::class);

        // Wywołanie seedera od użytkownikow
        $this->call(UsersTableSeeder::class);
    }
}
