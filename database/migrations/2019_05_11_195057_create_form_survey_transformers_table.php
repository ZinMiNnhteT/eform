<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormSurveyTransformersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_survey_transformers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('application_form_id');
            $table->integer('survey_engineer')->nullable();
            $table->string('pri_tsf_type')->nullable();
            $table->string('pri_tsf_name')->nullable();
            $table->string('pri_capacity')->nullable();
            $table->string('ct_ratio')->nullable();
            $table->string('ct_ratio_amt')->nullable();
            $table->string('pri_main_ct_ratio')->nullable();
            $table->string('pri_main_ct_ratio_amt')->nullable();
            $table->string('main_feeder_peak_load')->nullable();
            $table->string('main_feeder_peak_load_amt')->nullable();
            $table->string('pri_feeder_ct_ratio')->nullable();
            $table->string('pri_feeder_ct_ratio_amt')->nullable();
            $table->string('feeder_peak_load')->nullable();
            $table->string('feeder_peak_load_amt')->nullable();
            $table->string('sec_tsf_type')->nullable();
            $table->string('sec_tsf_name')->nullable();
            $table->string('sec_capacity')->nullable();
            $table->string('sec_main_ct_ratio')->nullable();
            $table->string('sec_main_ct_ratio_amt')->nullable();
            $table->string('sec_11_main_ct_ratio')->nullable();
            $table->string('sec_11_peak_load_day')->nullable();
            $table->string('sec_11_peak_load_night')->nullable();
            $table->string('sec_11_installed_capacity')->nullable();
            $table->string('feeder_name')->nullable();
            $table->string('feeder_ct_ratio')->nullable();
            $table->string('feeder_peak_load_day')->nullable();
            $table->string('feeder_peak_load_night')->nullable();
            $table->string('online_installed_capacity')->nullable();
            $table->string('total_line_length')->nullable();
            $table->string('request_line_length')->nullable();
            $table->text('conductor')->nullable();
            $table->string('string_change')->nullable();
            $table->text('string_change_type_length')->nullable();
            $table->string('power_station_recomm')->nullable();
            $table->string('one_line_diagram')->nullable();
            $table->string('location_map')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('google_map')->nullable();
            $table->string('comsumed_power_amt')->nullable();
            $table->string('comsumed_power_list')->nullable();
            $table->string('original_tsf')->nullable();
            $table->string('allowed_tsf')->nullable();
            $table->text('survey_remark')->nullable();
            $table->text('tsp_remark')->nullable();
            $table->text('dist_remark')->nullable();
            $table->string('capacitor_bank')->nullable();
            $table->string('capacitor_bank_amt')->nullable();
            $table->text('div_state_remark')->nullable();
            $table->text('head_office_remark')->nullable();
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
        Schema::dropIfExists('form_survey_transformers');
    }
}
