<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_files', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('application_form_id');
            $table->text('nrc_copy_front');
            $table->text('nrc_copy_back');
            $table->text('form_10_front')->nullable();
            $table->text('form_10_back')->nullable();
            $table->text('occupy_letter')->nullable();
            $table->text('no_invade_letter')->nullable();
            $table->text('ownership')->nullable();
            $table->text('electric_power')->nullable();
            $table->text('transaction_licence')->nullable();
            $table->text('building_permit')->nullable();
            $table->text('bcc')->nullable();
            $table->text('dc_recomm')->nullable();
            $table->text('prev_bill')->nullable();
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
        Schema::dropIfExists('application_files');
    }
}
