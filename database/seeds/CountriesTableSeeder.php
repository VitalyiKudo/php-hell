<?php

use App\Models\Country;
use Illuminate\Database\Seeder;
use PragmaRX\Countries\Package\Countries;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = (new Countries())->all();

        foreach ($countries as $value) {
            $country = Country::firstOrNew(['iso2' => $value->cca2]);

            $country->name = $value->name->common;
            $country->country_id = $value->cca2;
            $country->iso2 = $value->cca2;
            $country->iso3 = $value->cca3;

            $country->save();
        }
    }
}
