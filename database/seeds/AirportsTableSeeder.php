<?php

use App\Models\Airport;
use App\Models\City;
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
        // New local airports_202201102355.csv
        $header = NULL;
        $data = array();
        if (($handle = fopen(storage_path('app/airports_202201102355.csv'), 'r')) !== FALSE) {
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

                    $airport = Airport::firstOrNew(['icao' => $value['icao']]);
                    $city = City::firstOrNew(['geonameid'=>$value['geoNameIdCity']]);

                    $airport->name = $value['name'];
                    $airport->type = $value['type'];
                    $airport->city = $value['city'];
                    $airport->geonameid = $value['geonameid'];
                    $airport->iso_region = $value['iso_region'];
                    $airport->iso_country = $value['iso_country'];
                    $airport->city()->associate($city->geonameid);
                    $airport->iata = $value['iata'];
                    $airport->icao = $value['icao'];
                    $airport->latitude = $value['latitude'];
                    $airport->longitude = $value['longitude'];
                    $airport->timezone = $value['timezone'];

                    $airport->save();
                }
            } catch (Exception $e) {
                report($e);

                return false;
            }
        }
    }
}
