<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForm66sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form66s', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('application_form_id');
            $table->string('room_no')->nullable();
            $table->string('meter_no')->nullable();
            $table->string('water_meter_no')->nullable();
            $table->string('elevator_meter_no')->nullable();
            $table->string('meter_seal_no')->nullable();
            $table->date('meter_get_date')->nullable();
            $table->string('who_made_meter')->nullable();
            $table->string('ampere')->nullable();
            $table->date('pay_date')->nullable();
            $table->string('mark_user_no')->nullable();
            $table->string('budget')->nullable();
            $table->date('move_date')->nullable();
            $table->string('move_budget')->nullable();
            $table->string('move_order')->nullable();
            $table->date('test_date')->nullable();
            $table->string('test_no')->nullable();
            $table->text('remark')->nullable();
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
        Schema::dropIfExists('form66s');
    }
}
