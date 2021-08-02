<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(CargoLocationSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(RoleSeeder::class);
        User::factory(15)->create();
    }
}
