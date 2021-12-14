<?php

namespace Database\Seeders;

use App\Models\CargoLocation;
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
        CargoLocation::create(['name'=>'KYIV','city'=>'KYIV']);
        CargoLocation::create(['name'=>'KBP','city'=>'Kyiv Boryspil Airport']);
        CargoLocation::create(['name'=>'IEV','city'=>'Kyiv Zhulyany Airport']);
        CargoLocation::create(['name'=>'CKC','city'=>'CHERKASY']);
        CargoLocation::create(['name'=>'CWC','city'=>'CHERNIVTSI']);
        CargoLocation::create(['name'=>'CEJ','city'=>'CHERNIHIV']);
        CargoLocation::create(['name'=>'DNK','city'=>'DNIPRO']);
        CargoLocation::create(['name'=>'HRK','city'=>'KHARKIV']);
        CargoLocation::create(['name'=>'KHE','city'=>'KHERSON']);
        CargoLocation::create(['name'=>'HMJ','city'=>'KHMELNYTSYI']);
        CargoLocation::create(['name'=>'KGO','city'=>'KROPYVNYTSKYI']);
        CargoLocation::create(['name'=>'LWO','city'=>'LVIV']);
        CargoLocation::create(['name'=>'UCK','city'=>'LUTSK']);
        CargoLocation::create(['name'=>'ODS','city'=>'ODESSA']);
        CargoLocation::create(['name'=>'PLV','city'=>'POLTAVA']);
        CargoLocation::create(['name'=>'RWN','city'=>'RIVNE']);
        CargoLocation::create(['name'=>'UMY','city'=>'SUMY']);
        CargoLocation::create(['name'=>'TNL','city'=>'TERNOPIL']);
        CargoLocation::create(['name'=>'UDJ','city'=>'UZHHOROD']);
        CargoLocation::create(['name'=>'VIN','city'=>'VINNYTSIA']);
        CargoLocation::create(['name'=>'OZH','city'=>'ZAPORIZZHIA']);
        CargoLocation::create(['name'=>'ZTR','city'=>'ZHYTOMYR']);
        CargoLocation::create(['name'=>'CA-02-IEV','city'=>'CA-02-IEV']);
        CargoLocation::create(['name'=>'R-03-IEV','city'=>'R-03-IEV']);
        CargoLocation::create(['name'=>'NTC-01-IEV','city'=>'NTC-01-IEV']);
        CargoLocation::create(['name'=>'F-03-IEV','city'=>'F-03-IEV']);
    }
}
