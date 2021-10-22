<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->integer('status')->nullable();
            $table->string('status_name')->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('driver_id')->unsigned()->nullable();
            $table->bigInteger('agent_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('driver_id')->references('id')->on('users');
            $table->foreign('agent_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
