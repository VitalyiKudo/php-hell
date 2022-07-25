<?php

namespace App\Http\Controllers\Client\Account;

use App\Models\Airport;
use App\Models\City;
use App\Models\OrderStatus;
use App\Models\Search;
use App\Models\Pricing;
use App\Models\Order;

use Illuminate\Http\Request;
use \Validator;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Mail;
use Auth;
use DB;
use Session;
use Config;


class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:client');
    }

    public function index(Request $request)
    {
        Session::put('pervis_search_url', url()->full());

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

        $params["startPointName"] = $startCity ? $startCity : $request->startPoint;
        $params["endPointnName"] = $endCity ? $endCity : $request->endPoint;
        $params["flightDate"] = $request->flightDate ? $request->flightDate : NULL;
        $params["passengers"] = $request->passengers;
        $params["userId"] = Auth::user()->id;

        $searchResults =  Pricing::where('departure_geoId', '=', $startCity)->where('arrival_geoId', '=', $endCity)->first();

        if($searchResults){
            $params["result_id"] = $searchResults->id;
        } else {
            $params["result_id"] = 0;
        }

        $lastSearchResults = Search::with('departureCity', 'arrivalCity')
            ->where('user_id', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->take(4)
            ->get()
            ->reverse();

        $validator = Validator::make(
            [
                'startPoint' => $params["startPoint"],
                'endPoint' => $params["endPointn"],
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

        return view('client.account.requests.request', compact('searchResults', 'params', 'messages', 'lastSearchResults'));
    }

    public function findAirport($keyword) {
        $airport = Airport::where('name', $keyword)
            ->orWhere('name', str_replace('-', ' ', $keyword))
            ->orWhere('name', str_replace('.', '', $keyword))
            ->orWhere('city', $keyword)
            ->orWhere('city', str_replace('-', ' ', $keyword))
            ->orWhere('city', str_replace('.', '', $keyword))
            ->first();

        return $airport->id;
    }

    public function findCity($query) {
        $city = DB::table('cities')
            ->where('geonameid', $query)
            ->first();

        return is_object($city) ? $city->name : '';
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


    public function findCityByID($id) {

        $airport = Airport::find($id);

        return $airport->city;
    }

    public function requestQuote(Request $request)
    {
        $pervis_search_url = Session::get('pervis_search_url');

        $session_id = Session::getId();

        #$searchResult = Search::with('departureCity', 'arrivalCity')->where('user_id', Auth::user()->id)->latest()->first();

        $search = Search::firstOrCreate([
        'result_id' => $request->result_id,
        'user_id' => Auth::check() ? Auth::user()->id : NULL,
        'session_id' => $session_id,
        'departure_geoId' => $request->startPoint,
        'arrival_geoId' => $request->endPoint,
        'departure_at' => Carbon::parse($request->departure_at)->format('Y-m-d'),
        ],
        [
        'result_id' => $request->result_id,
        'user_id' => Auth::check() ? Auth::user()->id : NULL,
        'session_id' => $session_id,
        'start_airport_name' => $request->startAirport,
        'end_airport_name' => $request->endAirport,
        'departure_geoId' => $request->startPoint,
        'arrival_geoId' => $request->endPoint,
        'departure_at' => Carbon::parse($request->departure_at)->format('Y-m-d'),
        'pax' => $request->pax > 0 ? $request->pax : $request->passengers
        ]);

        $lastSearchResults = Search::with('departureCity', 'arrivalCity')
            ->where('user_id', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->take(4)
            ->get()
            ->reverse();

        $params = $request;
        $params['departure_at'] = $request->input('flightDate') ? Carbon::parse($request->input('flightDate'))->format('m/d/Y') : Carbon::parse($request->input('departure_at'))->format('m/d/Y');
        $params['passengers'] = $search->pax;

        return view('client.account.requests.requestQuote', compact('lastSearchResults', 'search', 'params', 'pervis_search_url'));
    }

    /**
     * @param Request     $request
     * @param Search      $search
     * @param OrderStatus $orderStatus
     * @param City        $city
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createQuote(Request $request, Search $search, OrderStatus $orderStatus, City $city){

        $comment = $request->input('comment') ? "Comment: ".$request->input('comment').";\r\n" : "";
        $comment .= $request->input('aircraft') ? "Preffered aircraft: " . $request->input('aircraft') . ";\r\n" : "" ;
        $comment .= $request->input('aircraft_one') ? "Preffered second aircraft: " . $request->input('aircraft_one') . ";\r\n" : "";
        $comment .= $request->input('aircraft_two') ? "Preffered third aircraft: " . $request->input('aircraft_two') . ";\r\n" : "";
        $comment .= $request->input('stopPoint') ? "Stop airport: " . $request->input('stopPoint') . ";\r\n" : "" ;
        $comment .= $request->input('returnPoint') ? "Return airport: " . $request->input('returnPoint') . ";\r\n" : "" ;
        $comment .= $request->input('fromStopPoint') ? "From Stop Airport: " . $request->input('fromStopPoint') . ";\r\n" : "" ;
        $comment .= $request->input('toStopPoint') ? "To Stop Airport: " . $request->input('toStopPoint') . ";\r\n" : "" ;
        $comment .= $request->input('stopFlightDate') ? "Stop Date: " . $request->input('stopFlightDate') . ";\r\n" : "" ;
        $comment .= $request->input('fromReturnPoint') ? "From Return Airport: " . $request->input('fromReturnPoint') . ";\r\n" : "" ;
        $comment .= $request->input('toReturnPoint') ? "To Return Airport: " . $request->input('toReturnPoint') . ";\r\n" : "" ;
        $comment .= $request->input('returnFlightDate') ? "Return Date: " . $request->input('returnFlightDate') . ";\r\n" : "" ;
        $comment .= $request->input('pets') ? "Pets: " . $request->input('pets') . ";\r\n" : "" ;
        $comment .= $request->input('bags') ? "Bags: ".$request->input('bags').";\r\n" : "" ;
        $comment .= $request->input('lbags') ? "Large baggage: ".$request->input('lbags').";\r\n" : "" ;
        $comment .= $request->input('wifi') ? "Wi-Fi: ".$request->input('wifi').";\r\n" : "" ;
        $comment .= $request->input('lavatory') ? "Lavatory: ".$request->input('lavatory').";\r\n" : "" ;
        $comment .= $request->input('disabilities') ? "People with disabilities: ".$request->input('disabilities').";\r\n" : "" ;
        $comment .= $request->input('catering') ? "Catering: ".$request->input('catering').";\r\n" : "" ;

        $search->find($request->input('search_id'))->update(['comment' => $comment, 'pax' => $request->input('passengers')]);

        $order = new Order;
        $order->user_id = Auth::user()->id;
        #$order->order_status_id = Config::get("constants.active.Awaiting for Acceptance");
        $order->order_status_id = $orderStatus->where('code', 'awaiting_payment')->first()->id;
        $order->search_result_id = $request->input('search_id');
        $order->comment = $comment;
        $order->type = $request->input('type');
        $order->book_status = 0;
        $order->save();

        Mail::send([], [], function ($message) use ($order) {
            $user = Auth::user();
            $message->from('request@jetonset.com', 'JetOnset team');
            //$message->from('quote@jetonset.com', 'JetOnset team');
            //$message->to('ju.odarjuk@gmail.com')->subject("Your request for quote on JetOnset # {$search_id}");
            $message->to($user->email)->subject("Your request for quote on JetOnset # {$order->id}");
            $message->setBody("Dear {$user->first_name} {$user->last_name}\n\nWe have received your request and will send you the quote in the shortest possible time.\nFor details and status of your request please use the link:\nhttps://jetonset.com/requests\n\nBest regards,\nJetOnset team.");
        });

        $date = Carbon::parse($request->input('flightDate'))->format('d F Y');
        $airports = [
            'start_city' => $city->where('geonameid', $request->input('startPoint'))->first()->name,
            'end_city' => $city->where('geonameid', $request->input('endPoint'))->first()->name
        ];

        Mail::send([], [], function ($message) use ($request, $order, $date, $airports, $comment) {
            $request_details = $comment ? "\r\n\r\nRequest details: \r\n" . $comment . "\r\n" : "";
            $user = Auth::user();
            $message->from($user->email, 'JetOnset team');
            $message->to('request@jetonset.com')->subject("We have request for you #{ $order->id} }");
            $message->setBody("Dear all!\n\nCan you send me the quote for a flight from {$airports['start_city']} to {$airports['end_city']} on {$date} for a company of {$request->input('passengers')} people for " . ucfirst($request->input('aircraft')) . " class of airplane.\n{$request->input('comment')} required. {$request_details}Best regards,\n{$user->first_name} {$user->last_name}\nJetOnset\n{$user->phone_number}");
        });

        return redirect()->route('client.search.requestQuoteSuccess', $order->id);
        #return view('client.account.requests.success');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function requestQuoteSuccess(Request $request){

        $lastSearchResults = Search::with('departureCity', 'arrivalCity')
            ->where('user_id', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->take(4)
            ->get()
            ->reverse();

        $params['reqest_number'] = $request->route('order_id');

        //echo $params['reqest_number'];

        return view('client.account.requests.requestQuoteSuccess', compact('lastSearchResults', 'params'));
    }



    public function sendMail(Request $request)
    {
        //Mail::to('ju.odarjuk@gmail.com')->send('Order status Updated');

        Mail::send([], [], function ($message) {
            $message->from('ju.odarjuk@gmail.com', 'Laravel');

            $message->to('ju.odarjuk@gmail.com')->subject("Email Testing with Laravel");

            $message->setBody("Dear ...\n\nWe have received your request and will send you the quote in the shortest possible time.\nFor details and status of your request please use the link:\nhttps://jetonset.com/requests\n\nBest regards,\nJetOnset team.");
        });

        /*
        $data = ['name', 'Ripon Uddin Arman'];

        Mail::send('client.emails.create_quote', $data, function ($message) {
            $message->from('ju.odarjuk@gmail.com', 'Laravel');

            $message->to('ju.odarjuk@gmail.com')->subject("Email Testing with Laravel");
        });
        */
return "ok";
}

}
