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
            'fullname' => 'Семёныч',
            'email' => '4@mail.com',
            'password' => Hash::make('123'),
        ]);
        DB::table('users')->insert([
            'name' => 'Driver',
            'nickname' => 'Driver',
            'fullname' => 'Петрович',
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
        DB::table('users')->insert([
            'name' => 'Agent2',
            'nickname' => 'Agent2',
            'fullname' => 'Семёныч2',
            'email' => '42@mail.com',
            'password' => Hash::make('123'),
        ]);
        DB::table('users')->insert([
            'name' => 'Agent3',
            'nickname' => 'Agent3',
            'fullname' => 'Семёныч3',
            'email' => '43@mail.com',
            'password' => Hash::make('123'),
        ]);
        DB::table('users')->insert([
            'name' => 'Driver2',
            'nickname' => 'Driver2',
            'fullname' => 'Петрович2',
            'email' => '52@mail.com',
            'password' => Hash::make('123'),
        ]);
        DB::table('users')->insert([
            'name' => 'Driver3',
            'nickname' => 'Driver3',
            'fullname' => 'Петрович3',
            'email' => '53@mail.com',
            'password' => Hash::make('123'),
        ]);
        DB::table('users')->insert([
            'name' => 'Driver4',
            'nickname' => 'Driver4',
            'fullname' => 'Петрович4',
            'email' => '54@mail.com',
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
        DB::table('role_user')->insert([
            'role_id' => 5,
            'user_id' => 9,
        ]);
        DB::table('role_user')->insert([
            'role_id' => 5,
            'user_id' => 10,
        ]);
        DB::table('role_user')->insert([
            'role_id' => 6,
            'user_id' => 11,
        ]);
        DB::table('role_user')->insert([
            'role_id' => 6,
            'user_id' => 12,
        ]);
        DB::table('role_user')->insert([
            'role_id' => 6,
            'user_id' => 13,
        ]);
    }
}
