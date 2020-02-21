<?php

use Illuminate\Database\Seeder;

class userTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('users')->delete();
		$userData = array(
			array(
				'id' => 1,
				'name' => 'adminDev',
				'firstName' => 'Super',
				'lastName' => 'Admin',
				'email' => 'devd4d@yopmail.com',
				'email_verified_at' =>  date("Y-m-d H:i:s"),
				'password' => bcrypt('qwert@123'),
				'remember_token' => null,
				'profile_photo' => null,
				'info' => null,
				'is_active' => '1',
				'phone' => '0123654789',
				'website' => 'www.test.com',
				'created_at' =>  date("Y-m-d H:i:s"),
				'updated_at' =>  date("Y-m-d H:i:s"),
			),
		);
		DB::table('users')->insert($userData);
	}
}
