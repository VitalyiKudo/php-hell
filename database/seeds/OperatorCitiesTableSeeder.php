<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Operator;
use App\Models\City;
use App\Models\Region;
use App\Models\Airline;
use App\Models\Airport;
use App\Models\OperatorCities;
use App\Models\OperatorJob;

class OperatorCitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $header = NULL;
        $data = array();

        try {
            $i = 0;
            $operators = OperatorJob::whereRaw('LENGTH(TRIM(`name`)) > 0')->whereRaw('LENGTH(TRIM(`email`)) > 0')->get();
            #$airlines = Airline::where('operator', $operator->name)->get();
            foreach ($operators as $operator) {
                $operatorsNew = Operator::firstOrNew(['email'=>$operator->email]);
                $operatorsNew->email = trim(strtolower($operator->email));
                $operatorsNew->name = trim($operator->name);
                $operatorsNew->web_site = trim(strtolower($operator->web_site));
                $operatorsNew->phone = trim($operator->phone);
                $operatorsNew->mobile = trim($operator->mobile);
                $operatorsNew->fax = trim($operator->fax);
                $operatorsNew->state = trim($operator->state);
                $operatorsNew->city = trim($operator->city);
                $operatorsNew->address = trim($operator->address);
                $operatorsNew->save();

                #$operatorsNew->city()->associate($city->geonameid);
                $airlines = Airline::where('operator', $operator->name)->get();
                echo "$i - $operator->name \n";
                if (!empty($airlines)) {
                    foreach ($airlines as $home) {
                        echo "$i - $home->homebase \n";
                        $cities = Airport::where('icao', $home->homebase)->where('geoNameIdCity', '<>', 0)->get();
                        foreach ($cities as $city) {
                            echo "$i - $city->geoNameIdCity \n";
                            OperatorCities::firstOrCreate(['email' => trim($operator->email), 'geoNameIdCity' => trim($city->geoNameIdCity)]);

                        }

                    }
                }
                $operatorsNew->save();
                Operator::where('active', 0)->where('email', trim($operator->email))->update(['active' => 1]);
                $i++;
            }
            /*
            $airport = Airport::where('icao', '=', $value['icao'])->firstOrFail();
            $city = City::where('geonameid', '=', $value['geoNameIdCity'])->firstOrFail();
            $area->airport()->associate($airport->icao);
            $area->city()->associate($city->geonameid);
            $area->save();
            **/
        }
        catch (ModelNotFoundException $ex) {

            echo $i." $operators->name --- $operators->email ----- \n";
            $i++;
        }

        #dd($airlines);
        #dd($operators->name);
        #Debugbar::info($operator);

        #$i=0;
        try {
            $operators = OperatorJob::where('email', 'NOT LIKE', '% %')->where('email', 'LIKE', '%@%')->whereRaw('LENGTH(TRIM(`operator`)) > 0')->whereRaw('LENGTH(TRIM(`email`)) > 0')
                ->get();
                #->toSql();
            #dd($operators);
            #$operators = OperatorJob::whereNotNull('operator')->whereNotNull('email')->where('email', '=', 'FLPOTEST10@CIINT.COM')->get();
            #$airlines = Airline::where('operator', $operator->name)->get();
            foreach ($operators as $operator) {
                $operatorsNew2 = Operator::firstOrNew(['email'=>$operator->email]);
                #$operatorsNew2->email = (empty($operatorsNew2->email)) ? strtolower($operator->email) : strtolower($operator->email);
                if (empty($operatorsNew2->email)) {$operatorsNew2->email = trim($operator->email);}
                if (empty($operatorsNew2->name)) {$operatorsNew2->name = trim($operator->operator);}
                if (empty($operatorsNew2->web_site)) {$operatorsNew2->web_site = trim(strtolower($operator->website));}
                echo "$i - Name \n";
                echo "$i - $operator->operator \n";
                echo "$i - $operator->name \n";
                echo "$i State - " . addcslashes($operator->state,"\0..\37") ." \n";
                echo "$i - $operator->city \n";
                echo "$i - Name End \n";
                #$operatorsNew2->web_site = (empty($operatorsNew2->web_site)) ? strtolower($operator->website) : strtolower($operator->web_site);
                $operatorsNew2->phone = (empty($operatorsNew2->phone)) ? trim(strtolower($operator->phone2)) : ((!empty($operator->phone2)) ? trim(strtolower($operatorsNew2->phone)) .', ' . trim(strtolower($operator->phone2)) :  trim(strtolower($operatorsNew2->phone)));
                #(a ? b : c) ? d : e` or `a ? b : (c ? d : e)
                $operatorsNew2->state = trim($operator->state);
                $operatorsNew2->city = trim($operator->city);

                $operatorsNew2->save();

                #$operatorsNew->city()->associate($city->geonameid);
                $regions = (!empty($operator->state)) ? Region::where('name', 'like', "%".trim($operator->state)."%")->whereNotNull('name')->whereRaw('LENGTH(TRIM(`name`)) > 0')->get() : null;
                    #->toSql();
                #dd($regions);
                #$cities = City::where('name', 'like', "%{$operator->city}%")->get();
                #echo "$i - $operator->name \n";
                if (!empty($regions)) {
                    foreach ($regions as $region) {
                        #echo "$i - $region->name \n";

                        #$regions = Region::where('region_id', $city->iso_region)->where('country_id', $city->iso_country)->get();
                        $cities = City::where('name', 'like', "%".trim($operator->city)."%")->where('iso_region', $region->region_id)->where('iso_country', $region->country_id)->get();
                        #$regions = City::with('city', 'city.regionCountry');
                        foreach ($cities as $city) {
                            echo "$i - $operator->operator \n";
                            echo "$i - $region->country_id \n";
                            echo "$i - $city->geonameid \n";
                            echo "$i - $city->name \n";
                            OperatorCities::firstOrCreate(['email' => trim(strtolower($operator->email)), 'geoNameIdCity' => trim($city->geonameid)])->where('email', '<>', 'call please')->where('email', 'NOT LIKE', ' ');
                            Operator::where('active', 0)->where('email', trim($operator->email))->update(['active' => 1]);
                            $i++;
                        }

                    }
                }
                #$operatorsNew->save();
                #$i++;
            }
            /*
            $airport = Airport::where('icao', '=', $value['icao'])->firstOrFail();
            $city = City::where('geonameid', '=', $value['geoNameIdCity'])->firstOrFail();
            $area->airport()->associate($airport->icao);
            $area->city()->associate($city->geonameid);
            $area->save();
            */
        }
        catch (ModelNotFoundException $ex) {

            echo $i." $operators->name --- $operators->email ----- \n";
            $i++;
        }

    }
}
