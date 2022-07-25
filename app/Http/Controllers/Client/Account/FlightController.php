<?php

namespace App\Http\Controllers\Client\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Config;
use Auth;
use Carbon\Carbon;
use \Validator;
use Session;
use DB;
use Str;

use App\Models\Order;
use App\Models\Pricing;
use App\Models\EmptyLeg;
use App\Models\Search;
use App\Models\City;

use App\Traits\CheckAgeUserTrait;

class FlightController extends Controller
{
    use CheckAgeUserTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Pricing $pricing, EmptyLeg $emptyLeg)
    {
        Session::put('pervis_search_url', url()->full());

        if(!session()->has('session_token_id')) {
            Session::put('session_token_id', md5(microtime() . 'salt' . time()));
        }

        $session_id = Session::get('session_token_id');

        $startPointName = $request->startPointName;
        $endPointName = $request->endPointName;

        $startCity = $request->startPoint;
        $endCity = $request->endPoint;

        $startAirport = $request->startAirport;
        $endAirport = $request->endAirport;

        $params["startPoint"] = $startCity ? $startCity : 0;
        $params["endPoint"] = $endCity ? $endCity : 0;
        $params["startAirport"] = $startAirport ? $startAirport : 0;
        $params["endAirport"] = $endAirport ? $endAirport : 0;
        $params["startPointName"] = $startPointName ? $startPointName : '';
        $params["endPointName"] = $endPointName ? $endPointName : '';
        $params["flightDate"] = $request->flightDate ? $request->flightDate : NULL;
        $params["passengers"] = $request->passengers;
        $params["userId"] = Auth::check() ? Auth::user()->id : 0;

        $searchResults = collect();

        $typePlanes = collect();
        foreach (Config::get('constants.plane.type_plane') as $key => $val) {
            $typePlanes->push(Str::after($key, '_'));
        }
        $typePlanes = $typePlanes->reverse();

        $stdRes = collect();
        $stdRes = $stdRes->put('quote', ['pricing' => true, 'type' => 'quote']);

        $searchResults->pricing = $pricing::with('departureCity', 'arrivalCity')
            ->where('departure_geoId', $startCity)
            ->where('arrival_geoId', $endCity)
            ->get()
            ->map(function ($value, $key) use($typePlanes)  {
                $item = collect();
                $typePlanes->each(function($type) use($value, $item) {
                    if ($value['price_'.$type] > 0) {
                        $item[$type] = collect([
                            'pricing' => true,
                           'price' => $value['price_'.$type],
                           'time' => $value['time_'.$type],
                           'type' => $type,
                           'startCity' => $value->departureCity->name,
                           'endtCity' => $value->arrivalCity->name,
                       ]);
                    }
                });
                return $item;
            })
        ->at(0);

        $searchResults->pricing = ($searchResults->pricing) ? $stdRes->merge($searchResults->pricing) : $stdRes;

        $searchResults->emptyLeg = $emptyLeg::with('departureCity', 'arrivalCity')
            ->where('geoNameIdCity_departure', $startCity)
            ->where('geoNameIdCity_arrival',$endCity)
            ->whereDate('date_departure', '=', Carbon::parse($request->flightDate)->format('Y-m-d'))
            #->orWhereDate('date_departure', '>', Carbon::parse($request->flightDate)->format('Y-m-d'))
            ->where('active', '=', Config::get('constants.active.Active'))
            #->toSql();
            ->get()
            ->sortByDesc('price');

        $countPricing = $searchResults->pricing->filter(function ($item, $key) {
            return ($item == true);
        })
        ->count();

        $searchResults = ($searchResults->pricing->merge($searchResults->emptyLeg))->reverse()->paginate(10);

        $lastSearchSessionResults = [
            'start_airport_name' => $params["startPointName"],
            'end_airport_name' => $params["endPointName"],
        ];


        $lastSessionSearchResults = [];
        if(Auth::check()){
            $lastSearchResults = Search::where('user_id', Auth::user()->id)
                                ->orderBy('id', 'desc')
                                ->take(4)
                                ->get()
                                ->reverse();
        }else{
            session()->push('last.search', $lastSearchSessionResults);
            $input = Session::get('last.search');
            $output = array_slice($input, -4);
            $lastSessionSearchResults = $output;

            $lastSearchResults = [];
        }

        $validator = Validator::make(
            [
                'startPoint' => $params["startPoint"],
                'endPoint' => $params["endPoint"],
                'startPointName' => $params["startAirport"],
                'endPointName' => $params["endAirport"],
                'flightDate' => $params["flightDate"],
                'passengers' => $params["passengers"],
            ],
            [
                'startPoint' => 'required|numeric',
                'endPoint' => 'required|numeric',
                'startPointName' => 'required|max:255',
                'endPointName' => 'required|max:255',
                'flightDate' => 'required|date',
                'passengers' => 'required|numeric',
            ]
        );

        $messages = NULL;
        if ($validator->fails()){
            $messages = $validator->messages();
        }

        $status = $this->CheckAge();

        return view('client.account.requests.request', compact('searchResults', 'params', 'messages', 'lastSearchResults', 'lastSessionSearchResults', 'status', 'countPricing'/*, 'page'*/));
    }


    public function old_index(Request $request)
    {
        Session::put('pervis_search_url', url()->full());

        //echo Session::get('pervis_search_url');

        $startCity = $this->findAirport($request->startId);
        $endCity = $this->findAirport($request->endId);

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
        $params["endPointName"] = $endCity ? $endCity : $request->endPoint;
        $params["flightDate"] = $request->flightDate ? $request->flightDate : NULL;
        $params["passengers"] = $request->passengers;

        $params["userId"] = 0;

        #$searchResults = Pricing::whereRaw("(`departure` like ? OR REPLACE(`departure`, '-', ' ') like ? OR REPLACE(`departure`, '.', '') like ?) AND (`arrival` like ? OR REPLACE(`arrival`, '-', ' ') like ? OR REPLACE(`arrival`, '.', '') like ?)", [$startCity, $startCity, $startCity, $endCity, $endCity, $endCity])->first();

        $searchResults =  Pricing::where('departure_geoId', '=', $startCity)->where('arrival_geoId', '=', $endCity)->first();

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

        //echo "<pre>";
        //print_r($lastSearchMiddle);
        //print_r($lastSearchResult);
        //print_r(Session::get('last_search_results'));
        //echo "</pre>";






        //$session_id = Session::getId();
        //echo $session_id;



/*
        $search = new Search;
        $search->result_id = $params["result_id"];
        $search->user_id = NULL;
        $search->start_airport_name = $params["startPointName"];
        $search->end_airport_name = $params["endPointName"];
        $search->departure_at = Carbon::parse($request->flightDate)->format('Y-m-d');
        $search->pax = $request->passengers > 0 ? $request->passengers : 0;
        $search->save();
*/





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
        $search->end_airport_name = $params["endPointName"];
        $search->departure_at = Carbon::parse($request->flightDate)->format('Y-m-d');
        $search->pax = $request->passengers > 0 ? $request->passengers : 0;
        $search->save();
        */




        //$params["searchId"] = $search->id;
        $params["searchId"] = 0;


        $validator = Validator::make(
            [
                'startPoint' => $params["startPointName"],
                'endPoint' => $params["endPointName"],
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
        $city = DB::table('cities')
                ->where('geonameid', $query)
                ->first();

        return is_object($city) ? $city->name : '';
    }

    public function findAirport($query) {
        $airport = DB::table('airports')
                ->where('id', $query)
                ->first();

        return is_object($airport) ? $airport->name : '';
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
