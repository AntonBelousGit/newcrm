<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payers')->insert([
            'customer_account_number' => '666',
            'customer_name' => 'xxx-dev',
            'customer_address' => 'Ukraine, Dnipro',
            'city' => 'Dnipro',
            'zip_code' => '49000',
            'country' => 'Ukraine',
            'contact_name' => 'Anton Belous',
            'phone' => '380000000000',
            'email' => 'antonbelouswork@gmail.com',
            'billing' => '3877777777777',
            'special' => '3866666666666',
        ]);
    }
}
