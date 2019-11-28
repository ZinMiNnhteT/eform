<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_actions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('application_form_id');
            $table->integer('form_accept')->nullable();
            $table->integer('form_pending')->nullable();
            $table->integer('survey_accept')->nullable();
            $table->integer('survey_confirm')->nullable();
            $table->integer('survey_confirm_dist')->nullable();
            $table->integer('survey_confirm_div_state')->nullable();
            $table->integer('survey_confirm_div_state_to_headoffice')->nullable();
            $table->integer('survey_confirm_headoffice')->nullable();
            $table->integer('announce')->nullable();
            $table->integer('payment_accept')->nullable();
            $table->integer('install_accept')->nullable();
            $table->integer('install_confirm')->nullable();
            // $table->integer('ei_confirm')->nullable();
            $table->integer('register_meter')->nullable();
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
        Schema::dropIfExists('admin_actions');
    }
}
