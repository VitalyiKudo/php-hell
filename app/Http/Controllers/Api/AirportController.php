<?php

namespace App\Http\Controllers\Api;

use App\Models\Airport;
use App\Models\Airline;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Airport as AirportResource;
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

        $airports = Airport::with('country', 'regionCountry')
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'like', "{$keyword}%")
                    ->orWhere('city', 'like', "{$keyword}%")
                    ->orWhere('city', 'like', str_replace("-", " ", $keyword)."%")
#                    ->orWhere('iata', 'like', "{$keyword}%")
                    ->orWhere('icao', 'like', "{$keyword}%")
                    //  search country
                    ->orWhereHas('regionCountry', function ($query) use ($keyword) {
                        $query->where('name', 'like', "%{$keyword}%");
                    });
                /*  search country
                ->orWhereHas('country', function ($query) use ($keyword) {
                        $query->where('name', 'like', "%{$keyword}%");
                    });*/
            })
#            ->limit(3)
            ->get();

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
