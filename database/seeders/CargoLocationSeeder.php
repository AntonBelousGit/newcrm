<?php

namespace Database\Seeders;

use App\Models\CargoLocation;
use App\Models\ProductStatus;
use Illuminate\Database\Seeder;

class CargoLocationSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        CargoLocation::create(['name'=>'----']);
        CargoLocation::create(['name'=>'APC-1']);
        CargoLocation::create(['name'=>'APC-2']);
        CargoLocation::create(['name'=>'APC-3']);
        CargoLocation::create(['name'=>'APC-3-x']);
    }
}
