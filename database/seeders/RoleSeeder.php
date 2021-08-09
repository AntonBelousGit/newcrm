<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();
        Role::create(['name'=>'SuperUser']);
        Role::create(['name'=>'Security Officer']);
        Role::create(['name'=>'Manager']);
        Role::create(['name'=>'OPS']);
        Role::create(['name'=>'Agent']);
        Role::create(['name'=>'Driver']);
        Role::create(['name'=>'View-Only']);
        Role::create(['name'=>'Client']);
    }
}
