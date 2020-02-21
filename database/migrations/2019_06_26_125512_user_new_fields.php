<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserNewFields extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('users', function (Blueprint $table) {
      $table->string('firstName')->nullable()->after('remember_token');
      $table->string('lastName')->nullable()->after('firstName');
      $table->longText('profile_photo')->nullable()->after('lastName');
      $table->enum('is_active', ['1', '0'])->default(0)->after('profile_photo')->comment = '1 = user is active / 0 = user is block';
      $table->string('phone')->nullable()->after('is_active');
      $table->string('website')->nullable()->after('phone');
      $table->longText('info')->nullable()->after('website');
      $table->string('contactEmail')->nullable()->after('info');
      $table->longText('addressLine')->nullable()->after('contactEmail');
      $table->string('addressLine2')->nullable()->after('addressLine');
      $table->string('addressCity')->nullable()->after('addressLine2');
      $table->string('addressState')->nullable()->after('addressCity');
      $table->string('addressCountry')->nullable()->after('addressState');
      $table->string('addressPostalCode')->nullable()->after('addressCountry');
      $table->string('driver_license_id')->nullable()->after('addressPostalCode');
      $table->string('driver_license_class')->nullable()->after('driver_license_id');
      $table->string('driver_license_expiry')->nullable()->after('driver_license_class');
      $table->string('national_id')->nullable()->after('driver_license_expiry');
      $table->string('insurance_company')->nullable()->after('national_id');
      $table->string('ontrac_username')->nullable()->after('insurance_company');
      $table->longText('ontrac_password')->nullable()->after('ontrac_username');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('users', function (Blueprint $table) {
      $table->dropColumn('firstName')->nullable();
      $table->dropColumn('lastName')->nullable();
      $table->dropColumn('profile_photo')->nullable();
      $table->dropColumn('is_active')->nullable();
      $table->dropColumn('phone')->nullable();
      $table->dropColumn('website')->nullable();
      $table->dropColumn('info')->nullable();
      $table->dropColumn('contactEmail')->nullable();
      $table->dropColumn('addressLine')->nullable();
      $table->dropColumn('addressLine2')->nullable();
      $table->dropColumn('addressCity')->nullable();
      $table->dropColumn('addressState')->nullable();
      $table->dropColumn('addressCountry')->nullable();
      $table->dropColumn('addressPostalCode')->nullable();
      $table->dropColumn('driver_license_id')->nullable();
      $table->dropColumn('driver_license_class')->nullable();
      $table->dropColumn('driver_license_expiry')->nullable();
      $table->dropColumn('national_id')->nullable();
      $table->dropColumn('insurance_company')->nullable();
      $table->dropColumn('ontrac_username')->nullable();
      $table->dropColumn('ontrac_password')->nullable();
    });
  }
}
