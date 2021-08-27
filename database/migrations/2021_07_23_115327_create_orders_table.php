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
            $table->integer('number_order')->unique()->nullable();
            $table->integer('invoice_number')->unique()->nullable();
            $table->string('checkout_number')->unique()->nullable();
            $table->string('phone_shipper');
//            $table->string('address_shipper');
            $table->string('company_shipper');
            $table->string('consignee');
            $table->string('phone_consignee');
//            $table->string('address_consignee');
            $table->string('company_consignee');
            $table->string('shipment_description')->nullable();
            $table->string('comment')->nullable();
            $table->string('locations')->nullable();
            $table->string('locations_id')->nullable();
            $table->timestamp('sending_time')->nullable();
            $table->timestamp('delivery_time')->nullable();
            $table->enum('sensor_for_rent',['on','off']);
            $table->enum('container',['on','off']);
            $table->enum('return_sensor',['on','off']);
            $table->enum('return_container',['on','off']);
            $table->integer('returned')->default(0);
            $table->string('delivery_comment')->nullable();
            $table->enum('notifications',['on','off']);
            $table->integer('payer_id');

            $table->bigInteger('order_id')->unsigned()->nullable();
            $table->bigInteger('client_id')->unsigned()->nullable();
            $table->bigInteger('cargo_location_id')->unsigned()->nullable();
            $table->bigInteger('status_id')->unsigned()->nullable();
            $table->bigInteger('substatus_id')->unsigned()->nullable();
            $table->bigInteger('agent_id')->unsigned()->nullable();
            $table->bigInteger('shipper_address_id')->unsigned()->nullable();
            $table->bigInteger('consignee_address_id')->unsigned()->nullable();

            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('status_id')->references('id')->on('product_statuses');
            $table->foreign('substatus_id')->references('id')->on('sub_product_statuses');
            $table->foreign('client_id')->references('id')->on('users');
            $table->foreign('agent_id')->references('id')->on('users');
            $table->foreign('cargo_location_id')->references('id')->on('cargo_locations');
            $table->foreign('shipper_address_id')->references('id')->on('cargo_locations');
            $table->foreign('consignee_address_id')->references('id')->on('cargo_locations');

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
