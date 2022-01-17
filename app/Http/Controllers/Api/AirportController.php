<?php

namespace App\Http\Controllers\Api;

use App\Models\Airport;
use App\Models\Airline;
use App\Models\Region;
use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Airport as AirportResource;
use Illuminate\Support\Facades\DB;
use libphonenumber\CountryCodeToRegionCodeMap;

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
/*
        $airports = Airport::with('country', 'regionCountry', 'cityNew')
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'like', "{$keyword}%")
                    ->orWhere('city', 'like', "{$keyword}%")
#                    ->orWhere('city', 'like', str_replace("-", " ", $keyword)."%")
#                    ->orWhere('iata', 'like', "{$keyword}%")
                    ->orWhere('icao', 'like', "{$keyword}%")
                    //  search country
                    ->orWhereHas('regionCountry', function ($query) use ($keyword) {
                        $query->where('name', 'like', "%{$keyword}%");
                    })
                    ->orWhereHas('cityNew', function ($query) use ($keyword) {
                        $query->where('name', 'like', "%{$keyword}%");
                    });
                /*  search country
                ->orWhereHas('country', function ($query) use ($keyword) {
                        $query->where('name', 'like', "%{$keyword}%");
                    });*
            })
#            ->limit(3)
            ->get();
*/

        $airports = DB::table('airports AS a')
                    ->leftJoin('cities AS c', 'a.geoNameIdCity', '=', 'c.geonameid')
                    ->leftJoin('regions AS r', function ($join) {
                        $join->on('c.iso_region', '=', 'r.region_id')
                            ->on('c.iso_country', '=', 'r.country_id')
                            ->on('a.geoNameIdCity', '=', 'c.geonameid');
                    })
                    ->leftJoin('countries AS co', 'r.country_id', '=', 'co.country_id')
                    ->select("c.geonameid", "a.icao", "a.name", "c.name as city", "r.name as region", "co.name as country")
                    ->where("a.name", "like", "%{$keyword}%")
                    ->orWhere("a.icao", "like", "%{$keyword}%")
                    ->orWhere("a.iata", "like", "%{$keyword}%")
                    ->where("a.geonameidcity", "<>", "0")
                    ->orWhere("c.name", "like", "%{$keyword}%")
                    ->orWhere("r.name", "like", "%{$keyword}%")
            ->limit(1000)
            ->get();
        #->toSql();

        //return AirportResource::collection($airports);
        return response()->json($airports);
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
}
