<?php

namespace Database\Seeders\Auth;

use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Class UsersTableSeeder
 */
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $superadmin = User::create([
            'name' => 'Superadmin',
            'email' => 'superadmin@mail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('root12'),
            'confirmed' => true,
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
        ]);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('root12'),
            'confirmed' => true,
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
        ]);

        $user = User::create([
            'name' => 'User',
            'email' => 'user@mail.com',
            'password' => Hash::make('root12'),
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
        ]);

        $superadmin->assignRole(config('access.roles.super_admin_role'));
        $admin->assignRole(config('access.roles.admin_role'));
        $user->assignRole(config('access.roles.user_role'));
    }
}
