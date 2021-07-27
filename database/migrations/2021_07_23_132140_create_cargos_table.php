<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCargosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cargos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id');
            $table->string('type');
            $table->integer('quantity');
            $table->integer('actual_weight');
            $table->integer('сargo_dimensions_height');
            $table->integer('сargo_dimensions_length');
            $table->integer('сargo_dimensions_width');
            $table->float('volume_weight');
            $table->string('serial_number')->nullable()->unique();
            $table->string('serial_number_sensor')->nullable();
            $table->string('un_number')->nullable()->unique();
            $table->float('temperature_conditions')->nullable();

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
        Schema::dropIfExists('cargos');
    }
}
