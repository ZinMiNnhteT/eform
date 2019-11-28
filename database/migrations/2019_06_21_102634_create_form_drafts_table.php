<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormDraftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_drafts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('application_form_id');
            $table->integer('apply_division')->default(2);
            $table->string('fullname')->nullable();
            $table->string('nrc')->nullable();
            $table->string('applied_phone')->nullable();
            $table->string('job_type')->nullable();
            $table->string('position')->nullable();
            $table->string('department')->nullable();
            $table->integer('salary')->default(0);
            $table->text('applied_building_type')->nullable();
            $table->string('applied_home_no')->nullable();
            $table->string('applied_building')->nullable();
            $table->string('applied_lane')->nullable();
            $table->string('applied_street')->nullable();
            $table->string('applied_quarter')->nullable();
            $table->string('applied_town')->nullable();
            $table->integer('township_id')->default(0);
            $table->integer('district_id')->default(0);
            $table->integer('div_state_id')->default(0);
            $table->date('date')->nullable();
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
        Schema::dropIfExists('form_drafts');
    }
}
