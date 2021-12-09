<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payers', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_account_number');
            $table->string('customer_name');
            $table->string('customer_address');
            $table->enum('status',['active','inactive'])->default('active');
            $table->string('city');
            $table->string('zip_code');
            $table->string('country');
            $table->string('contact_name');
            $table->string('phone');
            $table->string('email');
            $table->string('billing')->nullable();
            $table->string('special')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payers');
    }
}
