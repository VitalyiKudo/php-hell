<?php

use App\Models\Airport;
use App\Models\Country;
use Illuminate\Database\Seeder;

class AirportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $url = 'https://raw.githubusercontent.com/jpatokal/openflights/master/data/airports.dat';

        if (($handle = fopen(storage_path('app/airports.dat'), 'r')) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                $airport = Airport::firstOrNew(['source_id' => $data[0]]);

                $country = Country::where('name', $data[3])->first();

                $airport->name = $data[1];
                $airport->city = $data[2];
                $airport->country()->associate($country);
                $airport->iata = ($data[4] !== '\N') ? $data[4] : null;
                $airport->icao = ($data[5] !== '\N') ? $data[5] : null;
                $airport->latitude = $data[6];
                $airport->longitude = $data[7];
                $airport->timezone = $data[11];

                $airport->save();
            }

            fclose($handle);
        }
    }
}
