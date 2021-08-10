<?php

namespace Database\Seeders;

use App\Models\SubProductStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SubProductStatusSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        SubProductStatus::truncate();
        SubProductStatus::create(['name'=>'Pending Pick-Up','status_id'=>3]);
        SubProductStatus::create(['name'=>'In Transit','status_id'=>3]);
        SubProductStatus::create(['name'=>'Hold for Charges','status_id'=>4]);
        SubProductStatus::create(['name'=>'Ready to Bill','status_id'=>4]);
        SubProductStatus::create(['name'=>'Invoiced','status_id'=>4]);

    }
}
