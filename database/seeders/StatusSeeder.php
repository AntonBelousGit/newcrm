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
        ProductStatus::create(['name'=>'In processing']);
        ProductStatus::create(['name'=>'Accepted in work']);
        ProductStatus::create(['name'=>'Delivered']);
        ProductStatus::create(['name'=>'В подборе']);
    }
}
