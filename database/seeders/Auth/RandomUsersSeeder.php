<?php

namespace Database\Seeders\Auth;

use App\Models\User\User;
use Illuminate\Database\Seeder;

class RandomUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::factory()->count(1000)->create();

        foreach ($users as $user)
        {
            $user->assignRole(config('access.roles.user_role'));
        }
    }
}
