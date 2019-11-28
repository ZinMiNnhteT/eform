<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormEiChksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_ei_chks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('application_form_id');
            $table->text('ei_files')->nullable();
            $table->text('ei_remark')->nullable();
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
        Schema::dropIfExists('form_ei_chks');
    }
}
