<?php

use App\Models\Airline;

use Illuminate\Database\Seeder;

class AirlinesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // local airlines.csv
        $header = NULL;
        $data = array();
        if (($handle = fopen(storage_path('app/airlines.csv'), 'r')) !== FALSE) {
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

                    $airline = Airline::firstOrNew(['reg_number' => $value['reg_number']]);

                    $airline->source_id = $value['source_id'];
                    $airline->type = $value['type'];
                    $airline->reg_number = $value['reg_number'];
                    $airline->homebase = $value['homebase'];
                    $airline->max_pax = $value['max_pax'];
                    $airline->yom = $value['yom'];
                    $airline->operator = $value['operator'];

                    $airline->save();
                }
            } catch (Exception $e) {
                report($e);

                return false;
            }
        }
    }
}
