<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyRequestPermissionTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('company_request_permission', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('users_detail_id')->unsigned()->nullable();
            $table->foreign('users_detail_id')->references('id')->on('users_details_access')->onUpdate('cascade')->onDelete('cascade');
            // $table->integer('users_detail_id')->nullable();
            // $table->biginteger('permission_policy_id')->unsigned()->nullable();
            // $table->foreign('permission_policy_id')->references('id')->on('permission_policy_holder')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('permission_policy_id')->nullable();
            $table->enum('accept_status', ['0', '1', '2'])->default(0)->comment = '0 = pending / 1 = accept_status is true / 2 = accept_status is reject';
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
        Schema::dropIfExists('company_request_permission');
    }
}
