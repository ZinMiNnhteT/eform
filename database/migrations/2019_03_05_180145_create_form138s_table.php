<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForm138sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form138s', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('application_form_id');
            $table->date('form_send_date')->nullable();
            $table->date('form_get_date')->nullable();
            $table->text('description')->nullable();
            $table->integer('cash_kyat')->nullable();
            $table->string('calculator')->nullable();
            $table->date('calcu_date')->nullable();
            $table->string('payment_form_no')->nullable();
            $table->date('payment_form_date')->nullable();
            $table->string('deposite_form_no')->nullable();
            $table->date('deposite_form_date')->nullable();
            $table->string('somewhat')->nullable();
            $table->date('somewhat_form_date')->nullable();
            $table->string('string_form_no')->nullable();
            $table->date('string_form_date')->nullable();
            $table->date('service_string_form_date')->nullable();
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
        Schema::dropIfExists('form138s');
    }
}
