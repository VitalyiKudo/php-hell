<?php

namespace App\Http\Controllers\Api;

use App\Models\Airport;
#use App\Models\Airline;
use App\Models\Country;
use App\Models\Region;
use App\Models\City;
use App\Models\AirportAreas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Airport as AirportResource;
use Illuminate\Support\Facades\DB;
use libphonenumber\CountryCodeToRegionCodeMap;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AirportController extends Controller
{
    /**
     * Get the airports list.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAirportsList(Request $request)
    {
        $keyword = $request->input('query');

        /* Search Airports -> obj *
               $airports = Airport::with('city', 'city.regionCountry', 'city.country', 'airportAreas.city')
                    ->where(function ($query) use ($keyword) {
                        $query->where('name', 'like', "{$keyword}%")
                            #->orWhere('city', 'like', "{$keyword}%")
        #                    ->orWhere('city', 'like', str_replace("-", " ", $keyword)."%")
                            ->orWhere('iata', 'like', "{$keyword}%")
                            ->orWhere('icao', 'like', "{$keyword}%")
                            //  search city
                            ->orWhereHas('city', function ($query) use ($keyword) {
                                $query->where('name', 'like', "%{$keyword}%");
                            })
                            ->orWhereHas('city.regionCountry', function ($query) use ($keyword) {
                                $query->where('name', 'like', "%{$keyword}%");
                            })
                            ->orWhereHas('airportAreas.city', function ($query) use ($keyword) {
                                $query->where('name', 'like', "%{$keyword}%");
                            });
                            #->leftJoin('city.country');
                            /*->orWhereHas('cityNew', function ($query) use ($keyword) {
                                $query->where('name', 'like', "%{$keyword}%");
                            });
                        /*  search country
                        ->orWhereHas('country', function ($query) use ($keyword) {
                                $query->where('name', 'like', "%{$keyword}%");
                            });*
                    })
                    ->limit(10)
                    ->get();#;
                    #->groupBy('airportAreas.geoNameIdCity')
*/

        try {
            $airports = DB::table('airports AS a')
                #->select('a.geoNameIdCity', 'an.geoNameIdCity as area')
                ->selectRaw('IF(an.geoNameIdCity is null, a.geoNameIdCity, an.geoNameIdCity) as geonameid, a.icao, an.icao as anIcao')
                ->leftJoin('airport_areas AS an', 'a.icao', '=', 'an.icao')
                ->where("a.name", "like", "%{$keyword}%")
                ->orWhere("a.icao", "like", "%{$keyword}%")
                ->orWhere("a.iata", "like", "%{$keyword}%")
                ->where("a.geonameidcity", "<>", "0")
                ->get()
                ->groupBy('geonameid');
            $cities = DB::table('cities AS c')
                ->select('geonameid')
                ->where("c.name", "like", "%{$keyword}%")
                ->get()
                ->groupBy('geonameid');
            $regions = DB::table('regions AS r')
                ->select('c.geonameid', 'r.name as region')
                ->join('cities AS c', function ($join) {
                    $join->on('c.iso_region', '=', 'r.region_id')
                        ->on('c.iso_country', '=', 'r.country_id');
                })
                ->where("r.name", "like", "%{$keyword}%")
                ->get()
                ->groupBy('geonameid');
        } catch (ModelNotFoundException $ex) {
            report($ex);
        }

        $res = $airports->union($cities->all())->union($regions->all());
        $geonameid = $res->keys();

        $result = [];
        $i = 0;
        if ($res->isNotEmpty()) {
            $data = DB::table('cities AS c')
                ->selectRaw('IF(ar.geoNameIdCity is null, a.geoNameIdCity, ar.geoNameIdCity) as geonameid, co.name as country, a.icao, a.iata, a.name, c.name as city, r.name as region, co.iso2 as iso_country, ar.geoNameIdCity as areaid')
                ->leftJoin('countries AS co', 'c.iso_country', '=', 'co.country_id')
                ->leftJoin('regions AS r', function ($join) {
                    $join->on('c.iso_region', '=', 'r.region_id')
                        ->on('c.iso_country', '=', 'r.country_id');
                })
                ->leftJoin('airport_areas AS ar', 'c.geonameid', '=', 'ar.geoNameIdCity')
                ->leftJoin('airports AS a', function ($join) {
                    $join->on('c.geonameid', '=', 'a.geoNameIdCity')
                        ->orOn('ar.icao', '=', 'a.icao');
                })

                ->whereIn('c.geonameid', $geonameid)
                ->where('a.geoNameIdCity', '<>', 0)
                ->orderByRaw($this->sortCity())
                ->orderByRaw($this->sortCountry())
                ->orderBy('co.name')
                ->get()
                ->unique('icao')
                ->groupBy('geonameid');

            foreach ($data as $item=>$city) {
                foreach ($city as $key=>$value) {
                    if (empty($result[$i]['city'])) $result[$i]['city'] = $value->city;
                    if (empty($result[$i]['id'])) $result[$i]['id'] = $value->geonameid;
                    if (empty($result[$i]['region'])) $result[$i]['region'] = $value->region;
                    if (empty($result[$i]['country'])) $result[$i]['country'] = $value->country;

                    if (empty($result[$i]['areaid'])) $result[$i]['areaid'] = $value->areaid;
                    if (empty($result[$i]['area'])) $result[$i]['area'] = (empty($value->areaid)) ? 'City' : 'Area';

                    $result[$i]['airport'][$key]['name'] = $value->name;
                    $result[$i]['airport'][$key]['icao'] = $value->icao;
                    $result[$i]['airport'][$key]['iata'] = ($value->iata !== 'noV') ? $value->iata : '';
                }
                $i++;
            }

        }

        //return AirportResource::collection($airports);
        return response()->json($result);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTypesList(Request $request)
    {
        $keyword = $request->input('query');


        $airlines = Airline::where('type', 'like', "{$keyword}%")
                ->limit(10000)
                ->groupBy('type')
                ->get();

        return response()->json($airlines);
    }

    /**
     * @return string
     */
    protected function sortCountry(){
        $sortCountries = ['US' => 1,];
        $rawCountrySql = '(CASE ' . collect($sortCountries)->map(function($airport, $country){
                return "WHEN `co`.`iso2` = '{$country}' THEN {$airport}";
            })->implode(' ') . ' ELSE 9999 END) ASC';
        return $rawCountrySql;
    }

    /**
     * @return string
     */
    protected function sortCity(){
        $sortCities = [
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
        $rawCitySql = '(CASE ' . collect($sortCities)->map(function($airport, $city){
                return "WHEN `c`.`geonameid` = '{$city}' THEN {$airport}";
            })->implode(' ') . ' ELSE 9999 END) ASC';
        return $rawCitySql;
    }
}
