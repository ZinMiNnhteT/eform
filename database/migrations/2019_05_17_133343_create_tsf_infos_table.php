<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTsfInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tsf_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('application_form_id');
            // $table->string('tsf_type')->nullable(); /* ပင်မ / ထပ်ဆင့် */
            $table->integer('order_list')->nullable();
            $table->string('tsf_type')->nullable();
            $table->string('tsf_ht_kv')->nullable();
            $table->string('tsf_lt_kv')->nullable();
            $table->string('tsf_name')->nullable();
            $table->string('ct_ratio_ht')->nullable();
            $table->string('ct_ratio_lt')->nullable();
            $table->string('switch_gear')->nullable();
            $table->string('tsf_mva')->nullable();
            $table->string('install_cap')->nullable();
            $table->string('request_cap')->nullable();
            $table->string('highest_power_amp')->nullable();
            $table->string('highest_power_day')->nullable();
            $table->string('highest_power_night')->nullable();
            $table->string('tsf_load')->nullable();
            $table->text('line_size_length')->nullable();
            $table->string('tsf_line_ft_mile_total')->nullable();
            $table->string('tsf_line_ft_mile_req')->nullable();
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
        Schema::dropIfExists('tsf_infos');
    }
}
