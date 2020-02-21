<?php

use Illuminate\Database\Seeder;

class FuelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fuels')->delete();
        $fuelsData = array(
            array(
                'id' => 1,
                'fuels_type' => 'gas',
                'fuels_description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry', 
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ),
        );
        DB::table('fuels')->insert($fuelsData);

    }
}
