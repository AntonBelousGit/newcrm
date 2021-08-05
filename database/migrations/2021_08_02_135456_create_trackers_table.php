<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trackers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id');
            $table->bigInteger('location_id')->unsigned()->nullable();
            $table->string('address')->nullable();
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->enum('status',['Arrived','Awaiting arrival'])->default('Awaiting arrival');
            $table->enum('alert',['ok','bad'])->default('ok');
            $table->enum('position',[0,1,2])->default(1);

            $table->foreign('location_id')->references('id')->on('cargo_locations');

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
        Schema::dropIfExists('trackers');
    }
}