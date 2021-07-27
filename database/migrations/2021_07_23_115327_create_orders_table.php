<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('shipper');
            $table->string('phone_shipper');
            $table->string('address_shipper');
            $table->string('company_shipper');
            $table->string('consignee');
            $table->string('phone_consignee');
            $table->string('address_consignee');
            $table->string('company_consignee');
            $table->string('shipment_description');
            $table->string('comment');
            $table->date('sending_time');
            $table->date('delivery_time');
            $table->enum('sensor_for_rent',['on','off']);
            $table->enum('container',['on','off']);
            $table->enum('return_sensor',['on','off']);
            $table->enum('return_container',['on','off']);
            $table->string('delivery_comment');
            $table->string('cargo_location')->nullable();
            $table->enum('notifications',['on','off']);
            $table->foreignId('user_id')->constrained();
            $table->enum('status',['New order','In processing','Accepted in work','Delivered']);

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
        Schema::dropIfExists('orders');
    }
}
