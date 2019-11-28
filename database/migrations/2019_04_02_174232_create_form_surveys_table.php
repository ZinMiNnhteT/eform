<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_surveys', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('application_form_id');
            $table->integer('survey_engineer')->nullable();
            $table->timestamp('survey_date')->nullable();
            $table->integer('applied_type')->nullable();
            $table->string('phase_type')->nullable();
            $table->string('volt')->nullable();
            $table->string('kilowatt')->nullable();
            $table->string('distance')->nullable();
            $table->boolean('living')->nullable();
            $table->boolean('meter')->nullable();
            $table->boolean('invade')->nullable();
            $table->boolean('loaded')->nullable();
            $table->string('prev_meter_no')->nullable();
            $table->text('t_info')->nullable();
            $table->string('max_load')->nullable();
            $table->string('comsumed_power_amt')->nullable();
            $table->text('comsumed_power_file')->nullable();
            $table->integer('origin_p_meter')->nullable();
            $table->integer('allow_p_meter')->nullable();
            $table->string('transmit')->nullable();
            $table->text('r_power_files')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->text('remark')->nullable();

            $table->integer('meter_count')->nullable();
            $table->integer('pMeter10')->nullable();
            $table->integer('pMeter20')->nullable();
            $table->integer('pMeter30')->nullable();
            $table->integer('water_meter_count')->nullable();
            $table->integer('water_meter_type')->nullable();
            $table->integer('elevator_meter_count')->nullable();
            $table->integer('elevator_meter_type')->nullable();
            
            $table->text('tsf_transmit_distance_feet')->nullable();
            $table->text('tsf_transmit_distance_kv')->nullable();
            $table->text('exist_transformer')->nullable();
            $table->integer('amp')->nullable();
            $table->text('new_tsf_name')->nullable();
            $table->text('new_tsf_distance')->nullable();
            $table->text('distance_04')->nullable();
            $table->integer('new_line_type')->nullable();
            $table->string('new_tsf_info_volt')->nullable();
            $table->string('new_tsf_info_kv')->nullable();
            $table->string('new_tsf_info_volt_two')->nullable();
            $table->string('new_tsf_info_kv_two')->nullable();
            $table->integer('bq_cost')->nullable();
            $table->text('bq_cost_files')->nullable();
            $table->text('remark_tsp')->nullable();
            $table->integer('bq_cost_dist')->nullable();
            $table->text('bq_cost_dist_files')->nullable();
            $table->text('remark_dist')->nullable();
            $table->integer('bq_cost_div_state')->nullable();
            $table->text('bq_cost_div_state_files')->nullable();
            $table->text('remark_div_state')->nullable();
            $table->text('budget_name')->nullable();
            $table->text('location_files')->nullable();
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
        Schema::dropIfExists('form_surveys');
    }
}
