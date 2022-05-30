<?php

namespace App\Http\Controllers\Api\Account;

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
     * Display list of flights
     *
     * @return \Illuminate\Http\Response
     *
     * @OA\Get(
     *     path="/api/search/flight",
     *     description="Flights Page",
     *     tags={"Flight"},
     *     @OA\Parameter(
     *         description="Start Airport",
     *         in="query",
     *         name="startPointName",
     *         required=True,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         description="End Airport",
     *         in="query",
     *         name="endPointName",
     *         required=True,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         description="Date of flight",
     *         in="query",
     *         name="flightDate",
     *         required=True,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         description="Count of passengers",
     *         in="query",
     *         name="passengers",
     *         required=True,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         description="Departure geoId",
     *         in="query",
     *         name="startPoint",
     *         required=True,
     *         @OA\Schema(type="integer"),
     *     ),
     *     @OA\Parameter(
     *         description="Arrival geoId",
     *         in="query",
     *         name="endPoint",
     *         required=True,
     *         @OA\Schema(type="integer"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     *
     */


    public function index(Request $request, Pricing $pricing, EmptyLeg $emptyLeg)
    {
        Session::put('pervis_search_url_api', url()->full());
        $pervis_search_url = Session::get('pervis_search_url_api');
        //print_r($pervis_search_url);

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

        $searchResults = collect(['pricing', 'emptyLeg']);

        $searchResults->pricing = $pricing::with('departureCity', 'arrivalCity')
            ->where('departure_geoId', '=', $startCity)
            ->where('arrival_geoId', '=', $endCity)
            ->first();

        $searchResults->emptyLeg = $emptyLeg::with('departureCity', 'arrivalCity')
            ->where('geoNameIdCity_departure', '=', $startCity)
            ->where('geoNameIdCity_arrival', '=', $endCity)
            ->whereDate('date_departure', '=', Carbon::parse($request->flightDate)->format('Y-m-d'))
            ->where('active', '=', Config::get('constants.active.activated'))
            ->get();

        if($searchResults->pricing){
            $params["result_id"] = $searchResults->pricing->id;
        } else {
            $params["result_id"] = 0;
        }

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

        $search = new Search;
        $search->result_id = $params["result_id"];
        $search->user_id = Auth::check() ? Auth::user()->id : NULL;
        $search->session_id = $session_id;
        $search->start_airport_name = $params["startAirport"];
        $search->end_airport_name = $params["endAirport"];
        $search->departure_geoId = $params["startPoint"];
        $search->arrival_geoId = $params["endPoint"];
        $search->departure_at = Carbon::parse($request->flightDate)->format('Y-m-d');
        $search->pax = $request->passengers > 0 ? $request->passengers : 0;
        $search->save();

        $params["searchId"] = $search->id;

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

        return response()->json([
            'search_results' => ['pricing' => $searchResults->pricing, 'emptyLeg' => $searchResults->emptyLeg],
            'params' => $params,
            'messages' => $messages,
            'lastSearch_results' => $lastSearchResults,
            'last_session_search_results' => $lastSessionSearchResults,
            'status' => $status,
            'pervis_search_url' => $pervis_search_url,
        ]);
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
