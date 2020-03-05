<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('assets_id')->nullable();
            $table->string('tracker_id')->nullable();
            $table->string('label')->nullable();
            $table->string('max_speed')->nullable();
            $table->string('model')->nullable();
            $table->string('type')->nullable();
            $table->string('subtype')->nullable();
            $table->string('garage_id')->nullable();
            $table->string('status_id')->nullable();
            $table->string('trailer')->nullable();
            $table->string('manufacture_year')->nullable();
            $table->string('color')->nullable();
            $table->longText('additional_info')->nullable();
            $table->string('reg_number')->nullable();
            $table->string('vin')->nullable();
            $table->string('frame_number')->nullable();
            $table->string('payload_weight')->nullable();
            $table->string('payload_height')->nullable();
            $table->string('payload_length')->nullable();
            $table->string('payload_width')->nullable();
            $table->string('passengers')->nullable();
            $table->string('gross_weight')->nullable();
            $table->string('fuel_type')->nullable();
            $table->string('fuel_grade')->nullable();
            $table->string('norm_avg_fuel_consumption')->nullable();
            $table->string('fuel_tank_volume')->nullable();
            $table->string('fuel_cost')->nullable();
            $table->string('wheel_arrangement')->nullable();
            $table->string('tyre_size')->nullable();
            $table->string('tyres_number')->nullable();
            $table->string('liability_insurance_policy_number')->nullable();
            $table->string('liability_insurance_valid_till')->nullable();
            $table->string('free_insurance_policy_number')->nullable();
            $table->string('free_insurance_valid_till')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets');
    }
}
