<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->call(UserSeeder::class);
        $this->call(SubProductStatusSeeder::class);
        $this->call(CargoLocationSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(SubProductStatusSeeder::class);
        $this->call(RoleSeeder::class);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

//        User::factory(15)->create();
    }
}
