<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('apply_type');
            $table->integer('apply_sub_type');
            $table->integer('apply_division');
            $table->string('serial_code')->nullable();
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
            $table->integer('township_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->integer('div_state_id')->nullable();
            $table->date('date')->nullable();
            $table->timestamps();

            // new
            $table->string('business_name')->nullable();
            $table->integer('is_light')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('application_forms');
    }
}
