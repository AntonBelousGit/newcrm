<?php

namespace Database\Seeders;

use App\Models\ProductStatus;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'SuperAdmin',
            'email' => 'test@mail.com',
            'password' => Hash::make('123'),
        ]);
        DB::table('users')->insert([
            'name' => 'Security Officer',
            'nickname' => 'Security Officer',
            'email' => '1@mail.com',
            'password' => Hash::make('123'),
        ]);
        DB::table('users')->insert([
            'name' => 'Manager',
            'nickname' => 'Manager',
            'email' => '2@mail.com',
            'password' => Hash::make('123'),
        ]);
        DB::table('users')->insert([
            'name' => 'OPS',
            'nickname' => 'OPS',
            'email' => '3@mail.com',
            'password' => Hash::make('123'),
        ]);
        DB::table('users')->insert([
            'name' => 'Agent',
            'nickname' => 'Agent',
            'email' => '4@mail.com',
            'password' => Hash::make('123'),
        ]);
        DB::table('users')->insert([
            'name' => 'Driver',
            'nickname' => 'Driver',
            'email' => '5@mail.com',
            'password' => Hash::make('123'),
        ]);
        DB::table('users')->insert([
            'name' => 'View-Only',
            'nickname' => 'View-Only',
            'email' => '6@mail.com',
            'password' => Hash::make('123'),
        ]);
        DB::table('users')->insert([
            'name' => 'Client',
            'nickname' => 'Client',
            'email' => '7@mail.com',
            'password' => Hash::make('123'),
        ]);
        DB::table('role_user')->insert([
            'role_id' => 1,
            'user_id' => 1,
        ]);
        DB::table('role_user')->insert([
            'role_id' => 2,
            'user_id' => 2,
        ]);
        DB::table('role_user')->insert([
            'role_id' => 3,
            'user_id' => 3,
        ]);
        DB::table('role_user')->insert([
            'role_id' => 4,
            'user_id' => 4,
        ]);
        DB::table('role_user')->insert([
            'role_id' => 5,
            'user_id' => 5,
        ]);
        DB::table('role_user')->insert([
            'role_id' => 6,
            'user_id' => 6,
        ]);
        DB::table('role_user')->insert([
            'role_id' => 7,
            'user_id' => 7,
        ]);
        DB::table('role_user')->insert([
            'role_id' => 8,
            'user_id' => 8,
        ]);
    }
}
