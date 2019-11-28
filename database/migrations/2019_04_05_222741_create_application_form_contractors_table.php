<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationFormContractorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_form_contractors', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('application_form_id');
            $table->integer('room_count');
            $table->integer('pMeter10')->nullable();
            $table->integer('pMeter20')->nullable();
            $table->integer('pMeter30')->nullable();
            $table->integer('meter')->nullable();
            $table->boolean('water_meter')->nullable();
            $table->boolean('elevator_meter')->nullable();
            $table->timestamps();
            $table->foreign('application_form_id')->references('id')->on('application_forms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('application_form_contractors');
    }
}
