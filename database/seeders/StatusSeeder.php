<?php

namespace Database\Seeders;

use App\Models\ProductStatus;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        ProductStatus::create(['name'=>'New order']);
        ProductStatus::create(['name'=>'Accepted in work']);
        ProductStatus::create(['name'=>'Picked-up']);
        ProductStatus::create(['name'=>'>']);
        ProductStatus::create(['name'=>'POD Pending']);
        ProductStatus::create(['name'=>'Delivered']);
        ProductStatus::create(['name'=>'Invoiced']);
        ProductStatus::create(['name'=>'Point']);
    }
}
