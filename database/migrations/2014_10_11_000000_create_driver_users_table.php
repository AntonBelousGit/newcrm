<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_users', function (Blueprint $table) {
            $table->id();
            $table->string('car_model')->nullable();
            $table->string('gos_number_car')->nullable();
            $table->string('phone')->nullable();
            $table->unsignedBigInteger('agent_user_id')->nullable();
            $table->timestamps();

            $table->foreign('agent_user_id')->references('id')->on('agent_users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driver_users');
    }
}
