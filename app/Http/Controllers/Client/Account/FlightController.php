<?php

namespace App\Http\Controllers\Client\Account;

use Auth;
use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pricing;
use \Validator;
use Session;
use DB;

class FlightController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Session::put('pervis_search_url', url()->full());
        
        //echo Session::get('pervis_search_url');
        
        $startCity = $this->findCity($request->startPoint);
        $endCity = $this->findCity($request->endPoint);
        
        $startCityCoordinates = $this->findCoordinates($request->startPoint);
        $endCityCoordinates = $this->findCoordinates($request->endPoint);
        
        if(is_array($startCityCoordinates) && is_array($endCityCoordinates)){
            $params["startCityLat"] = $startCityCoordinates['lat'];
            $params["startCityLng"] = $startCityCoordinates['lng'];
            $params["endCityLat"] = $endCityCoordinates['lat'];
            $params["endCityLng"] = $endCityCoordinates['lng'];
            $params["biggerLat"] = ($params["startCityLat"] + $params["endCityLat"]) / 2;
            $params["biggerLng"] = ($params["startCityLng"] + $params["endCityLng"]) / 2;
        }

        //echo $params["startCityLng"];
      
        $params["startPointName"] = $startCity ? $startCity : $request->startPoint;
        $params["endPointnName"] = $endCity ? $endCity : $request->endPoint;
        $params["flightDate"] = $request->flightDate ? $request->flightDate : NULL;
        $params["passengers"] = $request->passengers;
        
        
        
        
        $params["userId"] = 0;
        
        
        
        
        
        $searchResults = Pricing::whereRaw("(`departure` like ? OR REPLACE(`departure`, '-', ' ') like ? OR REPLACE(`departure`, '.', '') like ?) AND (`arrival` like ? OR REPLACE(`arrival`, '-', ' ') like ? OR REPLACE(`arrival`, '.', '') like ?)", [$startCity, $startCity, $startCity, $endCity, $endCity, $endCity])->first();
        
        if($searchResults){
            $params["result_id"] = $searchResults->id;
        } else {
            $params["result_id"] = 0;
        }

        
        $lastSearchResults = [];
        //$lastSearchResult[] = ['start_airport_name' => 'test', 'end_airport_name' => 'test'];
        //$lastSearchResult[] = ['start_airport_name' => 'test', 'end_airport_name' => 'test'];
        //$lastSearchResult[] = ['start_airport_name' => 'test', 'end_airport_name' => 'test'];
        //$lastSearchResult[] = Session::get('last_search_results');
        
        //$lastSearchResult[] = ['start_airport_name' => 'test', 'end_airport_name' => 'test'];
        
        $lastSearchMiddleItem = [];
        //$lastSearchMiddleItem = Session::get('last_search_results');
        $lastSearchMiddle = array_push($lastSearchMiddleItem, ['start_airport_name' => 'test', 'end_airport_name' => 'test']);
        Session::put('last_search_results', $lastSearchMiddle);

        
        //$lastSearchResult[] = ['start_airport_name' => 'test', 'end_airport_name' => 'test'];
        
        echo "<pre>";
        //print_r($lastSearchMiddle);
        //print_r($lastSearchResult);
        print_r(Session::get('last_search_results'));
        echo "</pre>";
        
        
        //Session::forget('last_search_results');
        
        /*
        $lastSearchResults = Search::where('user_id', Auth::user()->id)
                                ->orderBy('id', 'desc')
                                ->take(4)
                                ->get()
                                ->reverse();
        
        
        
        $search = new Search;
        $search->result_id = $params["result_id"];
        $search->user_id = Auth::user()->id;
        $search->start_airport_name = $params["startPointName"];
        $search->end_airport_name = $params["endPointnName"];
        $search->departure_at = Carbon::parse($request->flightDate)->format('Y-m-d');
        $search->pax = $request->passengers > 0 ? $request->passengers : 0;
        $search->save();
        */
        
        
        
        
        //$params["searchId"] = $search->id;
        $params["searchId"] = 0;
        
        
        $validator = Validator::make(
            [
                'startPoint' => $params["startPointName"],
                'endPoint' => $params["endPointnName"],
                'flightDate' => $params["flightDate"],
                'passengers' => $params["passengers"],
            ],
            [
                'startPoint' => 'required|max:255',
                'endPoint' => 'required|max:255',
                'flightDate' => 'required|date',
                'passengers' => 'required|numeric',
            ]
        );

        $messages = NULL;
        if ($validator->fails()){
            $messages = $validator->messages();
        }

        return view('client.account.requests.search', compact('searchResults', 'params', 'messages', 'lastSearchResults'));
    }
    
    public function findCity($query) {
        $airport = DB::table('airports')
                ->where('name', $query)
                ->orWhere('name', str_replace('-', ' ', $query))
                ->orWhere('name', str_replace('.', '', $query))
                ->orWhere('city', $query)
                ->orWhere('city', str_replace('-', ' ', $query))
                ->orWhere('city', str_replace('.', '', $query))
                ->first();

        return is_object($airport) ? $airport->city : '';
    }
    
    public function findCoordinates($query) {
        $airport = DB::table('airports')
                ->where('name', $query)
                ->orWhere('name', str_replace('-', ' ', $query))
                ->orWhere('name', str_replace('.', '', $query))
                ->orWhere('city', $query)
                ->orWhere('city', str_replace('-', ' ', $query))
                ->orWhere('city', str_replace('.', '', $query))
                ->first();

        return is_object($airport) ? ['lat' => $airport->latitude, 'lng' => $airport->longitude] : NULL;
    }

}
