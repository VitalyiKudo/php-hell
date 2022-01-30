<?php

namespace App\Http\Controllers\Api;

use App\Models\Airport;
#use App\Models\Airline;
use App\Models\Country;
use App\Models\Region;
use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Airport as AirportResource;
use Illuminate\Support\Facades\DB;
use libphonenumber\CountryCodeToRegionCodeMap;
use Illuminate\Support\Collection;

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
/* Search Model -> obj
       $airports = Airport::with('city', 'city.regionCountry', 'city.country')
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
                    });
                    #->leftJoin('city.country');
                    /*->orWhereHas('cityNew', function ($query) use ($keyword) {
                        $query->where('name', 'like', "%{$keyword}%");
                    });
                /*  search country
                ->orWhereHas('country', function ($query) use ($keyword) {
                        $query->where('name', 'like', "%{$keyword}%");
                    });*
#            })
            ->limit(10)
            ->get()
            ->groupBy([function($item) { return $item->country->name; },
                          function($item) { return $item->city;}]);
*/
        $cities = DB::table('airports AS a')
                    ->select( "co.name as country", "c.geonameid", "a.icao", "a.iata", "a.name", "c.name as city", "r.name as region", "co.iso2 as iso_country" )
                    ->leftJoin('cities AS c', 'a.geoNameIdCity', '=', 'c.geonameid')
                    ->leftJoin('regions AS r', function ($join) {
                        $join->on('c.iso_region', '=', 'r.region_id')
                            ->on('c.iso_country', '=', 'r.country_id')
                            ->on('a.geoNameIdCity', '=', 'c.geonameid');
                    })
                    ->leftJoin('countries AS co', 'r.country_id', '=', 'co.country_id')
                    ->where("a.name", "like", "%{$keyword}%")
                    ->orWhere("a.icao", "like", "%{$keyword}%")
                    ->orWhere("a.iata", "like", "%{$keyword}%")
                    ->where("a.geonameidcity", "<>", "0")
                    ->orWhere("c.name", "like", "%{$keyword}%")
                    ->orWhere("r.name", "like", "%{$keyword}%")
            ->limit(100)
            ->orderByRaw($this->sortCity())
            ->orderByRaw($this->sortCountry())
            ->orderBy('co.name')
            ->get()
            ->groupBy('geonameid')
            ->toArray();
        $i = 0;
        $res = [];
        if(!empty($cities)) {
            foreach ($cities as $item=>$city) {
                foreach ($city as $key=>$value) {
                    if (empty($res[$i]['city'])) $res[$i]['city'] = $value->city;
                    if (empty($res[$i]['id'])) $res[$i]['id'] = $value->geonameid;
                    if (empty($res[$i]['region'])) $res[$i]['region'] = $value->region;
                    if (empty($res[$i]['country'])) $res[$i]['country'] = $value->country;
                    $res[$i]['airport'][$key]['name'] = $value->name;
                    $res[$i]['airport'][$key]['icao'] = $value->icao;
                    $res[$i]['airport'][$key]['iata'] = ($value->iata !== 'noV') ? $value->iata : '';
                }
                $i++;
            }
        }
        #dd($res);

        //return AirportResource::collection($airports);
        return response()->json($res);
        #return json_encode($res);;
    }

    public function getTypesList(Request $request)
    {
        $keyword = $request->input('query');


        $airlines = Airline::where('type', 'like', "{$keyword}%")
                ->limit(10000)
                ->groupBy('type')
                ->get();

        return response()->json($airlines);
    }

    protected function sortCountry(){
        $sortCountries = ['US' => 1,];
        $rawCountrySql = '(CASE ' . collect($sortCountries)->map(function($airport, $country){
                return "WHEN `co`.`iso2` = '{$country}' THEN {$airport}";
            })->implode(' ') . ' ELSE 9999 END) ASC';
        return $rawCountrySql;
    }

    protected function sortCity(){
        $sortCities = [
            4164223 => 1 ,# 	Miami	FL	US
            7219642 => 2 ,# 	Tampa	FL	US
            4167147 => 3 ,# 	Orlando	FL	US
            4160023 => 4 ,# 	Jacksonville	FL	US
            4174715 => 5 ,# 	Tallahassee	FL	US
            4168228 => 6 ,# 	Pensacola	FL	US
            4180439 => 7 ,# 	Atlanta	GA	US
            7228070 => 8 ,# 	Savannah	GA	US
            4574335 => 9 ,# 	Charleston	SC	US
            4575352 => 10,# 	Columbia	SC	US
            4580543 => 11,# 	Greenville	SC	US
            4460243 => 12,# 	Charlotte	NC	US
            4469146 => 13,# 	Greensboro	NC	US
            4781732 => 14,# 	Richmond	VA	US
            4776222 => 15,# 	Norfolk	VA	US
            4140998 => 16,# 	Washington	DC	US
            4347800 => 17,# 	Baltimore	MD	US
            5206379 => 18,# 	Pittsburgh	PA	US
            5192726 => 19,# 	Harrisburg	PA	US
            4560349 => 20,# 	Philadelphia	PA	US
            5178127 => 21,# 	Allentown	PA	US
            4145395 => 22,# 	Wilmington	DE	US
            4500546 => 23,# 	Atlantic City	NJ	US
            5101798 => 24,# 	Newark	NJ	US
            5128581 => 25,# 	New York	NY	US
            5144336 => 26,# 	White Plains	NY	US
            5140405 => 27,# 	Syracuse	NY	US
            5110629 => 28,# 	Buffalo	NY	US
            4835797 => 29,# 	Hartford	CT	US
            4930956 => 30,# 	Boston	MA	US
            5224151 => 31,# 	Providence	RI	US
            5089178 => 32,# 	Manchester	NH	US
            5234372 => 33,# 	Burlington	VT	US
            5746545 => 34,# 	Portland	OR	US
            4975802 => 35,# 	Portland	ME	US
            4509177 => 36,# 	Columbus	OH	US
            5150529 => 37,# 	Cleveland	OH	US
            4508722 => 38,# 	Cincinnati	OH	US
            4990729 => 39,# 	Detroit	MI	US
            4994358 => 40,# 	Grand Rapids	MI	US
            4998830 => 41,# 	Lansing	MI	US
            4259418 => 42,# 	Indianapolis	IN	US
            5263045 => 43,# 	Milwaukee	WI	US
            5254962 => 44,# 	Green Bay	WI	US
            4887442 => 45,# 	Chicago	IL	US
            4299276 => 46,# 	Louisville	KY	US
            4297990 => 47,# 	Lexington	KY	US
            4644585 => 48,# 	Nashville	TN	US
            4634946 => 49,# 	Knoxville	TN	US
            4641239 => 50,# 	Memphis	TN	US
            4076784 => 51,# 	Montgomery	AL	US
            4049979 => 52,# 	Birmingham	AL	US
            4431410 => 53,# 	Jackson	MS	US
            4335045 => 54,# 	New Orleans	LA	US
            4315584 => 55,# 	Baton Rouge	LA	US
            4119403 => 56,# 	Little Rock	AR	US
            4853828 => 57,# 	Des Moines	IA	US
            5037649 => 58,# 	Minneapolis	MN	US
            4699066 => 59,# 	Houston	TX	US
            4684888 => 60,# 	Dallas	TX	US
            4671654 => 61,# 	Austin	TX	US
            4726206 => 62,# 	San Antonio	TX	US
            4544349 => 63,# 	Oklahoma City	OK	US
            4553433 => 64,# 	Tulsa	OK	US
            4281733 => 65,# 	Wichita	KS	US
            5074525 => 66,# 	Omaha	NE	US
            5231851 => 67,# 	Sioux Falls	SD	US
            5419384 => 68,# 	Denver	CO	US
            5417598 => 69,# 	Colorado Springs	CO	US
            5441199 => 70,# 	Telluride	CO	US
            5454711 => 71,# 	Albuquerque	NM	US
            5308684 => 72,# 	Phoenix	AZ	US
            5318320 => 73,# 	Tucson	AZ	US
            5780993 => 74,# 	Salt Lake City	UT	US
            5809844 => 75,# 	Seattle	WA	US
            5811696 => 76,# 	Spokane	WA	US
            1022717 => 77,#  	Las Vegas	NV	US
            5511077 => 78,# 	Reno	NV	US
            8062678 => 79,# 	Los Angeles	CA	US
            5391811 => 80,# 	San Diego	CA	US
            5389489 => 81,# 	Sacramento	CA	US
            5392912 => 82,# 	Santa Ana	CA	US
            5392171 => 83,# 	San Jose	CA	US
            5879400 => 84,# 	Anchorage	AK	US
            5856195 => 85,# 	Honolulu	HI	US
            1188810 => 86,#  	Nassau	NP	BS
        ];
        $rawCitySql = '(CASE ' . collect($sortCities)->map(function($airport, $city){
                return "WHEN `c`.`geonameid` = '{$city}' THEN {$airport}";
            })->implode(' ') . ' ELSE 9999 END) ASC';
        return $rawCitySql;
    }
}
