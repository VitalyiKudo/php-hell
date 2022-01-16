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
        $this->call(CountriesTableSeeder::class);
        $this->call(RegionsTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(AirportsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(SearchesTableSeeder::class);
        $this->call(ServicesTableSeeder::class);
        $this->call(OrderStatusesTableSeeder::class);
        $this->call(OrdersTableSeeder::class);
        $this->call(AirlinesTableSeeder::class);
        $this->call(PricingsTableSeeder::class);
    }
}
