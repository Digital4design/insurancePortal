<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_list', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('access_id')->unsigned()->nullable();
            $table->foreign('access_id')->references('id')->on('users_details_access')->onUpdate('cascade')->onDelete('cascade');
            $table->biginteger('permission_id')->unsigned()->nullable();
            $table->foreign('permission_id')->references('id')->on('permission_policy_holder')->onUpdate('cascade')->onDelete('cascade');

            // $table->enum('speedType', ['speed', 'harsh'])->default('speed')->comment = 'speed / harsh';
            $table->string('tracker_id')->nullable();
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
        Schema::dropIfExists('permission_list');
    }
}
