<?php

namespace App\Http\Controllers\Api;

use App\Models\Airport;
use App\Models\Airline;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Airport as AirportResource;

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
        
        $airports = Airport::with('country')
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'like', "{$keyword}%")
                    ->orWhere('city', 'like', "{$keyword}%")
                    ->orWhere('city', 'like', str_replace("-", " ", $keyword)."%")
                    ->orWhere('iata', 'like', "{$keyword}%")
                    ->orWhere('icao', 'like', "{$keyword}%")
                    ->orWhere('area', 'like', "{$keyword}%")
                    ->orWhereHas('country', function ($query) use ($keyword) {
                        $query->where('name', 'like', "%{$keyword}%");
                    });
            })
            //->limit(10)
            ->get();

        //return AirportResource::collection($airports);
        
        return response()->json($airports);
    }
    
    public function getTypesList(Request $request)
    {
        $keyword = $request->input('query');
        
        
        $airlines = Airline::where('type', 'like', "{$keyword}%")
                ->limit(10)
                ->groupBy('type')
                ->get();

        return response()->json($airlines);
    }
}
