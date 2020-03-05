<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(userTableSeeder::class);
        $this->call(CountryTableSeeder::class);
        $this->call(StateTableSeeder::class);
        $this->call(CityTableSeeder::class);
        $this->call(PermissionPolicyHolderTableSeeder::class);
        $this->call(VehicleTableSeeder::class);
        $this->call(FuelTableSeeder::class);
        $this->call(Role::class);
        $this->call(roleUser::class);
    }
}
