<?php

use App\Models\City;
use App\Models\Country;
use App\Models\Region;
use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        if (($sql = file_get_contents(storage_path('app/cities_202201041545.sql'), 'r')) !== FALSE) {
            DB::statement($sql);
        }
        */
        // local cities_jobs_202201101339.csv
        $header = NULL;
        $data = array();
        if (($handle = fopen(storage_path('app/cities_jobs_202201101339.csv'), 'r')) !== FALSE) {
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
                    $city = City::firstOrNew(['geonameid' => (int)$value['geonameid']]);
                    $country = Country::firstOrCreate(['country_id' => $value['iso_country']]);
                    $region = Region::firstOrCreate(['country_id' => $value['iso_country'], 'region_id' => $value['iso_region']]);

                    $city->geonameid = (int)$value['geonameid'];
                    $city->name = $value['name'];
                    $city->asciiname = $value['asciiname'];
                    $city->iso_countryOld = $value['iso_countryOld'];
                    $city->country()->associate($country->country_id);
                    $city->region()->associate($region->region_id);
                    $city->latitude = $value['latitude'];
                    $city->longitude = $value['longitude'];
                    $city->timezone = $value['timezone'];

                    $city->save();
                }
            } catch (Exception $e) {
                report($e);

                return false;
            }
        }
    }
}
