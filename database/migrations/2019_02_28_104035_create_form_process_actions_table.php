<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormProcessActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_process_actions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('application_form_id');
            $table->boolean('user_send_to_office')->default(0);
            $table->text('user_send_form_date')->nullable();
            $table->boolean('form_reject')->default(0);
            $table->timestamp('reject_date')->nullable();
            $table->boolean('form_pending')->default(0);
            $table->timestamp('pending_date')->nullable();
            $table->boolean('form_accept')->default(0);
            $table->timestamp('accepted_date')->nullable();
            $table->boolean('survey_accept')->default(0);
            $table->timestamp('survey_accepted_date')->nullable();
            $table->boolean('survey_confirm')->default(0);
            $table->timestamp('survey_confirmed_date')->nullable();
            $table->boolean('survey_confirm_dist')->default(0);
            $table->timestamp('survey_confirmed_dist_date')->nullable();
            $table->boolean('survey_confirm_div_state')->default(0);
            $table->timestamp('survey_confirmed_div_state_date')->nullable();
            $table->boolean('survey_confirm_div_state_to_headoffice')->default(0);
            $table->timestamp('survey_confirmed_div_state_to_headoffice_date')->nullable();
            $table->boolean('survey_confirm_headoffice')->default(0);
            $table->timestamp('survey_confirmed_headoffice_date')->nullable();
            $table->boolean('announce')->default(0);
            $table->timestamp('announced_date')->nullable();
            $table->boolean('user_pay')->default(0);
            $table->timestamp('user_paid_date')->nullable();
            $table->boolean('payment_accept')->default(0);
            $table->timestamp('payment_accepted_date')->nullable();
            $table->boolean('install_accept')->default(0);
            $table->timestamp('install_accepted_date')->nullable();
            $table->boolean('install_confirm')->default(0);
            $table->timestamp('install_confirmed_date')->nullable();
            $table->boolean('register_meter')->default(0);
            $table->timestamp('registered_meter_date')->nullable();
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
        Schema::dropIfExists('form_process_actions');
    }
}
