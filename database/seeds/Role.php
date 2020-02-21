<?php

use Illuminate\Database\Seeder;

class Role extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('roles')->delete();
		$roleData = array(
			array(
				'id'			=>	1,
				'name'			=>	'admin',
				'display_name'	=>	'Admin maintenance complete website',
				'description'	=>  'This is super admin role for login',
				'created_at'	=>  date("Y-m-d H:i:s"),
				'updated_at'	=>  date("Y-m-d H:i:s"),
			),
			array(
				'id'			=>	2,
				'name'			=>	'company',
				'display_name'	=>	'Insurance Company',
				'description'	=>	'Insurance Company',
				'created_at'	=>	date("Y-m-d H:i:s"),
				'updated_at'	=>	date("Y-m-d H:i:s"),
			),
			array(
				'id'			=>	3,
				'name'			=>	'user',
				'display_name'	=>	'Policy Holders user',
				'description'	=>	'Policy Holders user',
				'created_at'	=>	date("Y-m-d H:i:s"),
				'updated_at'	=>	date("Y-m-d H:i:s"),
			),
		);
		DB::table('roles')->insert($roleData);
	}
}
