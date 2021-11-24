<?php

use App\Models\Airport;
use App\Models\Country;
use App\Models\Region;
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
        // Old $url = 'https://raw.githubusercontent.com/jpatokal/openflights/master/data/airports.dat';
        // New local Airports_final_02_06_Alex.csv
        $header = NULL;
        $data = array();
        if (($handle = fopen(storage_path('app/Airports_final_02_06_Alex.csv'), 'r')) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, ';')) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }

        if (!empty($data)) {
            try {
                foreach ($data as $value) {

                    $airport = Airport::firstOrNew(['icao' => $value['ident']]);
                    $country = Country::firstOrCreate(['country_id' => $value['iso_country']]);
                    $regionJob = trim(substr($value['iso_region'], strpos($value['iso_region'], "-") + 1));
                    $region = Region::firstOrCreate(['country_id' => $value['iso_country'], 'region_id' => $regionJob]);

                    $airport->name = $value['name'];
                    $airport->city = $value['municipality'];
                    $airport->country()->associate($country->country_id);
                    $airport->region()->associate($region->region_id);
                    $airport->continent_id = ($value['continent'] !== '\N') ? $value['continent'] : 'NA';
                    $airport->iata = ($value['iata_code'] !== '\N') ? $value['iata_code'] : null;
                    $airport->icao = $value['ident'];
                    $airport->latitude = $value['latitude_deg'];
                    $airport->longitude = $value['longitude_deg'];
                    #$airport->timezone = $value[11];

                    $airport->save();

                }
            } catch (Exception $e) {
                report($e);

                return false;
            }
        }
    }
}
