<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Airport;
use App\Models\City;
use App\Models\AirportArea;

class AirportAreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // local areas.csv
        $header = NULL;
        $data = array();
        if (($handle = fopen(storage_path('app/areas.csv'), 'r')) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
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
                $i=0;
                foreach ($data as $value) {
                    try {
                        $area = AirportArea::firstOrNew(['icao' => $value['icao'], 'geoNameIdCity' => $value['geoNameIdCity']]);
                        $airport = Airport::where('icao', '=', $value['icao'])->firstOrFail();
                        $city = City::where('geonameid', '=', $value['geoNameIdCity'])->firstOrFail();
                        $area->airport()->associate($airport->icao);
                        $area->city()->associate($city->geonameid);
                        $area->save();
                    }
                    catch (ModelNotFoundException $ex) {
                        $i++;
                        echo $i." $airport->icao --- $city->geonameid ----- \n";
                    }
                }
            } catch (Exception $e) {
                report($e);

                return false;
            }
        }
    }
}
