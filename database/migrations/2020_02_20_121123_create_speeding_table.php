<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpeedingTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('speeding', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('company_id')->unsigned()->nullable();
            $table->foreign('company_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('speeding_start')->nullable();
            $table->string('speeding_end')->nullable();
            $table->string('rating')->nullable();
            $table->enum('speedType', ['speed', 'harsh'])->default('speed')->comment = 'speed / harsh';
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('speeding');
    }
}
