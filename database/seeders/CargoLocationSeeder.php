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

        CargoLocation::create(['name'=>'----','city'=>'----']);
        CargoLocation::create(['name'=>'IEV','city'=>'KYIV']);
        CargoLocation::create(['name'=>'HRK','city'=>'KHARKIV']);
        CargoLocation::create(['name'=>'ODS','city'=>'ODESA']);
        CargoLocation::create(['name'=>'LWO','city'=>'LVIV']);
        CargoLocation::create(['name'=>'KHE','city'=>'KHERSON']);
        CargoLocation::create(['name'=>'OZH','city'=>'ZAPORIZHZHIA']);
        CargoLocation::create(['name'=>'UDJ','city'=>'UZHHOROD']);
        CargoLocation::create(['name'=>'DNK','city'=>'DNIPRO']);
        CargoLocation::create(['name'=>'IFO','city'=>'IVANO-FRANKIVSK']);
        CargoLocation::create(['name'=>'ZTR','city'=>'ZHYTOMYR']);
    }
}
