<?php
namespace App\Http\Traits;

use App\Models\City;

trait SearchCityAirportsTrait {
    /**
     * @param $keyword
     *
     * @return mixed
     */
    public function SearchCityAirportNameLike($keyword)
    {
        return City::with('regionCountry', 'country', 'airport', 'airportAreas', 'airportAreas.airport')
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'like', "{$keyword}%")
                    ->orWhereHas('airport', function ($query) use ($keyword) {
                        $query->where('name', 'like', "%{$keyword}%")
                            ->orWhere('iata', 'like', "{$keyword}%")
                            ->orWhere('icao', 'like', "{$keyword}%");
                    })
                    ->orWhereHas('airportAreas.airport', function ($query) use ($keyword) {
                        $query->where('name', 'like', "%{$keyword}%")
                            ->orWhere('iata', 'like', "{$keyword}%")
                            ->orWhere('icao', 'like', "{$keyword}%");
                    })
                    ->orWhereHas('regionCountry', function ($query) use ($keyword) {
                        $query->where('name', 'like', "%{$keyword}%");
                    });
            })
            ->orderByRaw($this->sortAreaUS())
            ->orderByRaw($this->sortCountryUS())
            ->get()
            ->map(fn($value) => [
                'geonameid' =>  $value->geonameid,
                'isoCountry' => $value->country->country_id ?? null,
                'city' => $value->name ?? null,
                'region' => $value->regionCountry->name ?? null,
                'country' => $value->country->name ?? null,
                'area' => ($value->airportAreas->count() > 0) ? 'Area' : 'City',
                'airportFull' => $value->airport->map(fn($city) => [
                    'icao' => $city->icao,
                    'iata' => (!empty($city->iata) && $city->iata !== 'noV') ? $city->iata : null,
                    'name' => $city->name ?? null,
                ])->keyBy('icao')
                    ->union($value->airportAreas->map(fn($area) => [
                        'icao' => $area->airport->at(0)->icao,
                        'iata' => (!empty($area->airport->at(0)->iata) && $area->airport->at(0)->iata !== 'noV') ? $area->airport->at(0)->iata : null,
                        'name' => $area->airport->at(0)->name ?? null,
                    ])->keyBy('icao')),
                'airportCity' => $value->airport->map(fn($city) => [
                    'icao' => $city->icao,
                    'iata' => (!empty($city->iata) && $city->iata !== 'noV') ? $city->iata : null,
                    'name' => $city->name ?? null,
                ])->keyBy('icao'),
                'airportArea' => $value->airportAreas->map(fn($area) => [
                    'icao' => $area->airport->at(0)->icao,
                    'iata' => (!empty($area->airport->at(0)->iata) && $area->airport->at(0)->iata !== 'noV') ? $area->airport->at(0)->iata : null,
                    'name' => $area->airport->at(0)->name ?? null,
                ])->keyBy('icao')
            ])
            ->whereNotIn('geonameid', [0]);
    }

    /**
     * @return string
     */
    private function sortCountryUS(){
        $sortCountries = ['US' => 1,];
        $rawCountrySql = sprintf(
            "(CASE %s ELSE 9999 END) ASC",
            collect($sortCountries)->map(function ($key, $iso) {
                return "WHEN `cities`.`iso_country` = '{$iso}' THEN {$key}";
            })->implode(' ')
        );
        return $rawCountrySql;
    }


    /**
     * @return string
     */
    private function sortAreaUS(){
        $sortArea = [
            5128581 => 1, #    'New York'
            4140998 => 2, #    'Washington'
            4164223 => 3, #    'Miami'
            8062678 => 4, #    'Los Angeles'
            5391959 => 5, #    'San Francisco'
            4887442 => 6, #    'Chicago'
            5419384 => 7, #    'Denver'
            7219642 => 8, #    'Tampa'
            4167147 => 9, #    'Orlando'
            4160023 => 10, #    'Jacksonville'
            4174715 => 11, #    'Tallahassee'
            4168228 => 12, #    'Pensacola'
            4180439 => 13, #    'Atlanta'
            7228070 => 14, #    'Savannah'
            4574335 => 15, #    'Charleston'
            4575352 => 16, #    'Columbia'
            4580543 => 17, #    'Greenville'
            4460243 => 18, #    'Charlotte'
            4469146 => 19, #    'Greensboro'
            4781732 => 20, #    'Richmond'
            4776222 => 21, #    'Norfolk'
            4347800 => 22, #    'Baltimore'
            5206379 => 23, #    'Pittsburgh'
            5192726 => 24, #    'Harrisburg'
            4560349 => 25, #    'Philadelphia'
            5178127 => 26, #    'Allentown'
            4145395 => 27, #    'Wilmington'
            4500546 => 28, #    'Atlantic City'
            5101798 => 29, #    'Newark'
            5144336 => 30, #    'White Plains'
            7258233 => 31, #    'East Hampton'
            5106834 => 32, #    'Albany'
            5140405 => 33, #    'Syracuse'
            5110629 => 34, #    'Buffalo'
            4835797 => 35, #    'Hartford'
            4930956 => 36, #    'Boston'
            4937346 => 37, #    'Springfield-Chicopee'
            5224151 => 38, #    'Providence'
            5089178 => 39, #    'Manchester'
            5234372 => 40, #    'Burlington'
            4975802 => 41, #    'Portland'
            4509177 => 42, #    'Columbus'
            5150529 => 43, #    'Cleveland'
            4508722 => 44, #    'Cincinnati'
            4990729 => 45, #    'Detroit'
            4994358 => 46, #    'Grand Rapids'
            4998830 => 47, #    'Lansing'
            4259418 => 48, #    'Indianapolis'
            5263045 => 49, #    'Milwaukee'
            5254962 => 50, #    'Green Bay'
            4299276 => 51, #    'Louisville'
            4297990 => 52, #    'Lexington'
            4644585 => 53, #    'Nashville'
            4634946 => 54, #    'Knoxville'
            4641239 => 55, #    'Memphis'
            4076784 => 56, #    'Montgomery'
            4049979 => 57, #    'Birmingham'
            4431410 => 58, #    'Jackson'
            4335045 => 59, #    'New Orleans'
            4315584 => 60, #    'Baton Rouge'
            4119403 => 61, #    'Little Rock'
            7702153 => 62, #    'St Louis'
            4853828 => 63, #    'Des Moines'
            5037649 => 64, #    'Minneapolis'
            4699066 => 65, #    'Houston'
            4684888 => 66, #    'Dallas'
            4671654 => 67, #    'Austin'
            4726206 => 68, #    'San Antonio'
            4544349 => 69, #    'Oklahoma City'
            4553433 => 70, #    'Tulsa'
            4393217 => 71, #    'Kansas City'
            4281733 => 72, #    'Wichita'
            5074525 => 73, #    'Omaha'
            5231851 => 74, #    'Sioux Falls'
            5412230 => 75, #    'Aspen'
            5417598 => 76, #    'Colorado Springs'
            5442727 => 77, #    'Vail'
            5441199 => 78, #    'Telluride'
            5454711 => 79, #    'Albuquerque'
            5308684 => 80, #    'Phoenix'
            5318320 => 81, #    'Tucson'
            5780993 => 82, #    'Salt Lake City'
            5809844 => 83, #    'Seattle'
            5811696 => 84, #    'Spokane'
            5746545 => 85, #    'Portland'
            1022717 => 86, #    'Las Vegas'
            5511077 => 87, #    'Reno'
            5391811 => 88, #    'San Diego'
            5389489 => 89, #    'Sacramento'
            5392912 => 90, #    'Santa Ana'
            5392171 => 91, #    'San Jose'
            5879400 => 92, #    'Anchorage'
            5856195 => 93, #    'Honolulu'
            11888109 => 94 #    'Nassau'
        ];
        $rawCitySql = sprintf(
            "(CASE %s ELSE 9999 END) ASC",
            collect($sortArea)->map(function ($key, $id) {
                return "WHEN `cities`.`geonameid` = '{$id}' THEN {$key}";
            })->implode(' ')
        );
        return $rawCitySql;
    }
}

