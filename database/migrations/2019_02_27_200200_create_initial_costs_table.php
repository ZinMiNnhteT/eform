<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInitialCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('initial_costs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type');
            $table->integer('sub_type');
            $table->string('name');
            $table->string('slug');
            $table->integer('assign_fee')->nullable();
            $table->integer('deposit_fee')->nullable();
            $table->integer('string_fee')->nullable();
            $table->integer('service_fee')->nullable();
            $table->integer('incheck_fee')->nullable();
            $table->integer('registration_fee')->nullable();
            $table->integer('composit_box')->nullable();
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
        Schema::dropIfExists('initial_costs');
    }
}
