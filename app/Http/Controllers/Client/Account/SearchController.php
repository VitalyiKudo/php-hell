<?php

namespace App\Http\Controllers\Client\Account;

use App\Models\Airport;
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
dd($request);
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

        #$searchResults = Pricing::whereRaw("(`departure` like ? OR REPLACE(`departure`, '-', ' ') like ? OR REPLACE(`departure`, '.', '') like ?) AND (`arrival` like ? OR REPLACE(`arrival`, '-', ' ') like ? OR REPLACE(`arrival`, '.', '') like ?)", [$startCity, $startCity, $startCity, $endCity, $endCity, $endCity])->first();

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
/*
        $search = new Search;
        $search->result_id = $params["result_id"];
        $search->user_id = Auth::user()->id;
        $search->start_airport_name = $params["startPointName"];
        $search->end_airport_name = $params["endPointnName"];
        $search->departure_at = Carbon::parse($request->flightDate)->format('Y-m-d');
        $search->pax = $request->passengers > 0 ? $request->passengers : 0;
        $search->save();

        $params["searchId"] = $search->id;
*/
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
        #dd($request);

        /*
        $search = new Order;
        $search->user_id = $request->input('user_id');
        $search->order_status_id = 5;
        $search->search_result_id = $request->input('result_id');
        $search->comment = $request->input('comment');
        $search->type = $request->input('flight_model');
        $search->save();

        $search_id = $search->id;

        Mail::send([], [], function ($message) use ($search_id) {
            $user = Auth::user();
            $message->from('quote@jetonset.com', 'JetOnset team');
            //$message->to('ju.odarjuk@gmail.com')->subject("Your request for quote on JetOnset # {$search_id}");
            $message->to($user->email)->subject("We have received your request");
            $message->setBody("Dear {$user->first_name} {$user->last_name}\n\nWe have received your request and will send you the quote in the shortest possible time.\n\nBest regards,\nJetOnset team.");
        });


        $date = Carbon::parse($request->input('departure_at'))->format('d F Y');
        $airports = [
            'start_city' => $request->input('start_airport_name'),
            'end_city' => $request->input('end_airport_name'),
        ];

        Mail::send([], [], function ($message) use ($request, $date, $airports) {
            $user = Auth::user();
            $message->from($user->email, 'JetOnset team');
            $message->to('quote@jetonset.com')->subject("We have request for you #{$request->input('result_id')}");
            $message->setBody("Dear all!\n\nCan you send me the quote for a flight from {$airports['start_city']} to {$airports['end_city']} on {$date} for a company of {$request->input('pax')} people for " . ucfirst($request->input('flight_model')) . " class of airplane.\n{$request->input('comment')} required.\n\nBest regards,\n{$user->first_name} {$user->last_name}\nJetOnset\n{$user->phone_number}");
        });
        */


        /* not needed
        $airport_list = [];
        $airport_items = Airport::whereIn('city', [$request->input('start_airport_name'), $request->input('end_airport_name')])->get();
        foreach($airport_items as $airport_item){
            if($airport_item->icao){
                $airport_list[] = $airport_item->icao;
            }
        }
        $airport_list = array_unique($airport_list);

        $operator_list = [];
        $airlines = Airline::where('category', $request->input('flight_model'))->whereIn('homebase', $airport_list)->get();

        foreach($airlines as $airline){
            $operator_list[] = $airline->operator;
        }
        $operator_list = array_unique($operator_list);

        $emails = [];
        $operators = Operator::whereIn('name', $operator_list)->get();
        foreach($operators as $operator){
            if ($operator->email == trim($operator->email) && strpos($operator->email, ' ') !== false) {
                $mail_list = explode(" ", $operator->email);
                foreach($mail_list as $mail){
                    $emails[] = trim($mail);
                }
                $mail_list = [];
            } else if(strstr($operator->email, PHP_EOL)) {
                $mail_list = explode(PHP_EOL, $operator->email);
                foreach($mail_list as $mail){
                    $emails[] = trim($mail);
                }
                $mail_list = [];
            } else {
                $emails[] = trim($operator->email);
            }
        }

        $date = Carbon::parse($request->input('departure_at'))->format('d F Y');
        $airports = [
            'start_city' => $request->input('start_airport_name'),
            'end_city' => $request->input('end_airport_name'),
        ];

        $emails = array_unique($emails);

        foreach($emails as $email){
            Mail::send([], [], function ($message) use ($email, $request, $date, $airports) {
                $user = Auth::user();
                $message->from($user->email, 'JetOnset team');
                //$message->to('ju.odarjuk@gmail.com')->subject("We have received your request");
                $message->to($email)->subject("We have request for you #{$request->input('result_id')}");
                //$message->to($user->email)->subject("We have received your request");
                $message->setBody("Dear all!\n\nCan you send me the quote for a flight from {$airports['start_city']} to {$airports['end_city']} on {$date} for a company of {$request->input('pax')} people for " . ucfirst($request->input('flight_model')) . " class of airplane.\n{$request->input('comment')} required.\n\nBest regards,\n{$user->first_name} {$user->last_name}\nJetOnset\n{$user->phone_number}");
            });
        }
        */
        //return response()->json([]);

        $pervis_search_url = Session::get('pervis_search_url');

        //$session_id = Session::getId();
        //echo $session_id;

#dd($request->page_name);
        $session_id = Session::get('session_token_id');
        //echo $session_id;
/*
        $search_updates = Search::where('session_id', $session_id)->get();
        #var_dump($request);
        #dd($search_updates);
        if($search_updates){
            foreach ($search_updates as $search_update) {
                $search_update->user_id = Auth::user()->id;
                $search_update->save();
            }
        }
*/

        //$search_update->user_id = Auth::user()->id;
        //$search_update->update(['user_id' => Auth::user()->id]);

        //echo "<pre>";
        //print_r($search_update);
        //echo "</pre>";



        #$searchResult = Search::with('departureCity', 'arrivalCity')->where('user_id', Auth::user()->id)->latest()->first();

        $search = new Search;
        $search->result_id = $request->result_id;
        $search->user_id = Auth::check() ? Auth::user()->id : NULL;
        $search->session_id = $session_id;
        $search->start_airport_name = $request->startAirport;
        $search->end_airport_name = $request->endAirport;
        $search->departure_geoId = $request->startPoint;
        $search->arrival_geoId = $request->endPoint;
        $search->departure_at = Carbon::parse($request->departure_at)->format('Y-m-d');
        $search->pax = $request->pax > 0 ? $request->pax : $request->passengers;
        $search->save();

        $lastSearchResults = Search::with('departureCity', 'arrivalCity')
            ->where('user_id', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->take(4)
            ->get()
            ->reverse();

        $params = $request;
        $params['departure_at'] = $request->input('flightDate') ? Carbon::parse($request->input('flightDate'))->format('m/d/Y') : Carbon::parse($request->input('departure_at'))->format('m/d/Y');
        $params['passengers'] = $search->pax;
#dd($params);
#dd($search['start_airport_name']);
#dd($search);
/*
        $params['startPoint'] = $request->input('startPoint');
        $params['endPoint'] = $request->input('endPoint');
        $params['startAirport'] = $request->input('startAirport');
        $params['endAirport'] = $request->input('endAirport');

        $startCity = $this->findCity($request->input('startPoint'));
        $endCity = $this->findCity($request->input('endPoint'));

        $params['start_airport_name'] = $startCity ? $startCity : $request->input('startPoint');
        $params['end_airport_name'] = $endCity ? $endCity : $request->input('endPoint');
        $params['start_airport'] = $request->input('startAirport');
        $params['end_airport'] = $request->input('endAirport');
        $params['from_stop_airport_name'] = $request->input('fromStopPoint');
        $params['to_stop_airport_name'] = $request->input('toStopPoint');
        $params['from_return_airport_name'] = $request->input('fromReturnPoint');
        $params['to_return_airport_name'] = $request->input('toReturnPoint');
        $params['departure_at'] = $request->input('flightDate') ? Carbon::parse($request->input('flightDate'))->format('m/d/Y') : Carbon::parse($request->input('departure_at'))->format('m/d/Y');
        $params['stop_at'] = $request->input('stopFlightDate') ? Carbon::parse($request->input('stopFlightDate'))->format('m/d/Y') : '';
        $params['return_at'] = $request->input('returnFlightDate') ? Carbon::parse($request->input('returnFlightDate'))->format('m/d/Y') : '';
        $params['result_id'] = $request->input('result_id');
        $params['pax'] = $request->input('pax');
        $params['passengers'] = $request->input('pax');
        $params['flight_model'] = $request->input('flight_model');
        $params['comment'] = $request->input('comment');
        $params['previous'] = url()->previous();
        $params['aircraft'] = $request->input('aircraft');
        $params['aircraft_one'] = $request->input('aircraft_one');
        $params['aircraft_two'] = $request->input('aircraft_two');
        $params['pets'] = $request->input('pets');
        $params['bags'] = $request->input('bags');
        $params['lbags'] = $request->input('lbags');
        $params['wifi'] = $request->input('wifi');
        $params['lavatory'] = $request->input('lavatory');
        $params['disabilities'] = $request->input('disabilities');
        $params['catering'] = $request->input('catering');
*/
        $comment = "";
/*
        if($request->isMethod('get') && $request->input('page_name') == "reqest-page" && strlen($params['start_airport_name']) > 0 && strlen($params['end_airport_name']) > 0 && strlen($params['departure_at']) > 0 && $params['pax'] > 0){
            $comment .= $request->input('comment') ? "Comment: " . $request->input('comment') . ";\r\n" : "" ;
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
    #dd(Config::get("constants.active.Awaiting for Acceptance"));

            /*
            $search = new Order;
            $search->user_id = Auth::user()->id;
            $search->order_status_id = Config::get("constants.active.Awaiting for Acceptance");
            $search->search_result_id = $searchResult->id;
            $search->comment = $comment;
            $search->type = $params['aircraft'];
            $search->book_status = 0;
            $search->save();

            $search_id = $search->id;

            Mail::send([], [], function ($message) use ($search_id) {
                $user = Auth::user();
                $message->from('request@jetonset.com', 'JetOnset team');
                //$message->from('quote@jetonset.com', 'JetOnset team');
                //$message->to('ju.odarjuk@gmail.com')->subject("Your request for quote on JetOnset # {$search_id}");
                $message->to($user->email)->subject("Your request for quote on JetOnset # {$search_id}");
                $message->setBody("Dear {$user->first_name} {$user->last_name}\n\nWe have received your request and will send you the quote in the shortest possible time.\nFor details and status of your request please use the link:\nhttps://jetonset.com/requests\n\nBest regards,\nJetOnset team.");
            });

            $date = Carbon::parse($request->input('flightDate'))->format('d F Y');
            $airports = [
                'start_city' => $startCity,
                'end_city' => $endCity,
            ];

            Mail::send([], [], function ($message) use ($request, $date, $airports, $comment) {
                $request_details = $comment ? "\r\n\r\nRequest details: \r\n" . $comment . "\r\n" : "";
                $user = Auth::user();
                $message->from($user->email, 'JetOnset team');
                //$message->to('quote@jetonset.com')->subject("We have request for you #{$request->input('result_id')}");
                $message->to('request@jetonset.com')->subject("We have request for you #{$request->input('result_id')}");
                $message->setBody("Dear all!\n\nCan you send me the quote for a flight from {$airports['start_city']} to {$airports['end_city']} on {$date} for a company of {$request->input('pax')} people for " . ucfirst($request->input('flight_model')) . " class of airplane.\n{$request->input('comment')} required. {$request_details}Best regards,\n{$user->first_name} {$user->last_name}\nJetOnset\n{$user->phone_number}");
            });
*
            //return view('client.account.requests.requestQuote', compact('lastSearchResults', 'searchResult', 'params', 'pervis_search_url'));
            return redirect()->route('client.search.requestQuoteSuccess', $search->id);
        } else {
            return view('client.account.requests.requestQuote', compact('lastSearchResults', /*'searchResult',/ 'params', 'pervis_search_url'));
        }
*/
        //echo $request->input('returnPoint');
        //echo $request->input('catering');
        //echo $searchResult->start_airport_name." - ".$searchResult->end_airport_name." - ";
        //echo $searchResult->departure_at." - ".$searchResult->pax." - ";
        //echo $searchResult->result_id;
        return view('client.account.requests.requestQuote', compact('lastSearchResults', 'search', 'params', 'pervis_search_url'));
    }

    public function createQuote(Request $request){

        #dd($request);
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

        $order = new Order;
        $order->user_id = Auth::user()->id;
        $order->order_status_id = Config::get("constants.active.Awaiting for Acceptance");
        $order->search_result_id = $request->input('search_id');
        $order->comment = $comment;
        $order->type = $request->input('aircraft');
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
            'start_city' => 'test',#$startCity,
            'end_city' => 'test',#$endCity,
        ];

        Mail::send([], [], function ($message) use ($request, $order, $date, $airports, $comment) {
            $request_details = $comment ? "\r\n\r\nRequest details: \r\n" . $comment . "\r\n" : "";
            $user = Auth::user();
            $message->from($user->email, 'JetOnset team');
            $message->to('request@jetonset.com')->subject("We have request for you #{ $order->id} }");
            $message->setBody("Dear all!\n\nCan you send me the quote for a flight from {$airports['start_city']} to {$airports['end_city']} on {$date} for a company of {$request->input('pax')} people for " . ucfirst($request->input('flight_model')) . " class of airplane.\n{$request->input('comment')} required. {$request_details}Best regards,\n{$user->first_name} {$user->last_name}\nJetOnset\n{$user->phone_number}");
        });

        return redirect()->route('client.search.requestQuoteSuccess', $order->id);

        #dd($search);
        #return view('client.account.requests.success');
    }


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
