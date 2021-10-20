<?php

use App\Models\Region;
use Illuminate\Database\Seeder;
use PragmaRX\Countries\Package\Countries;

class RegionsTableSeeder extends Seeder
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
            $iso2 = $value->cca2;
            $regions = $countries->where('cca2', $iso2)->first()->hydrateStates()->states->pluck('name', 'postal')->toArray();

            foreach ($regions as $key=>$val) {

                $country = \App\Models\Country::where('country_id', $iso2)->first();
                $region = Region::firstOrNew(['country_id' => $iso2, 'region_id' => $key]);

                $region->country()->associate($country->country_id);
                $region->region_id = $key;
                $region->name = $val;
                $region->code = $key;

                $region->save();
           }
        }
    }
}
