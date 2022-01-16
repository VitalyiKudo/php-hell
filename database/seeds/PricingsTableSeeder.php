<?php
use App\Models\Pricing;
use App\Models\City;

use Illuminate\Database\Seeder;

class PricingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // local pricings_202201151410.csv
        $header = NULL;
        $data = array();
        if (($handle = fopen(storage_path('app/pricings_202201151410.csv'), 'r')) !== FALSE) {
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

                    $price = Pricing::firstOrNew(['departure' => $value['departure'], 'arrival' => $value['arrival']]);
                    $departureId = City::firstOrNew(['geonameid'=>$value['departure_geoId']]);
                    $arrivalId = City::firstOrNew(['geonameid'=>$value['arrival_geoId']]);

                    $price->source_id = $value['source_id'];
                    $price->departure = $value['departure'];
                    $price->arrival = $value['arrival'];
                    $price->time_turbo = $value['time_turbo'];
                    $price->price_turbo = $value['price_turbo'];
                    $price->time_light = $value['time_light'];
                    $price->price_light = $value['price_light'];
                    $price->time_medium = $value['time_medium'];
                    $price->price_medium = $value['price_medium'];
                    $price->time_heavy = $value['time_heavy'];
                    $price->price_heavy = $value['price_heavy'];
                    $price->departure()->associate($departureId->geonameid);
                    $price->arrival()->associate($arrivalId->geonameid);

                    $price->save();
                }
            } catch (Exception $e) {
                report($e);

                return false;
            }
        }
    }
}
