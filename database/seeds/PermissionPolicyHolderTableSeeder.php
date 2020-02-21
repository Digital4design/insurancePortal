<?php

use Illuminate\Database\Seeder;

class PermissionPolicyHolderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission_policy_holder')->delete();
        $userData = array(
            array(
                'id' => 1,
                'permissions_name' => 'Location',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ),
            array(
                'id' => 2,
                'permissions_name' => 'Odometer', 
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ),
            array(
                'id' => 3,
                'permissions_name' => 'Violations',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ),
            array(
                'id' => 4,
                'permissions_name' => 'Mileage',                
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ),
        );
        DB::table('permission_policy_holder')->insert($userData);
    }
}