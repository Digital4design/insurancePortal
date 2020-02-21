<?php

use Illuminate\Database\Seeder;

class VehicleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vehicles')->delete();
        $vehiclesData = array(
            array(
                'id' => 1,
                'vehicles_type' => 'car',
                'vehicles_description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ),
        );
        DB::table('vehicles')->insert($vehiclesData);

    }
}
