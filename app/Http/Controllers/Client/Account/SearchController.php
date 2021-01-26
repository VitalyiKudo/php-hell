<?php

namespace App\Http\Controllers\Client\Account;

use App\Models\Airport;
use App\Models\Search;
use App\Models\Airline;
use App\Models\Operator;
use Illuminate\Http\Request;
use \Validator;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use App\Models\Avinode;
use Carbon\Carbon;
use App\Models\Order;
use Mail;
use App\Models\Pricing;
use Auth;
use DB;


class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:client');
    }

    public function index(Request $request)
    {
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
        $params["userId"] = Auth::user()->id;
        
        $searchResults = Pricing::whereRaw("(`departure` like ? OR REPLACE(`departure`, '-', ' ') like ? OR REPLACE(`departure`, '.', '') like ?) AND (`arrival` like ? OR REPLACE(`arrival`, '-', ' ') like ? OR REPLACE(`arrival`, '.', '') like ?)", [$startCity, $startCity, $startCity, $endCity, $endCity, $endCity])->first();
        
        if($searchResults){
            $params["result_id"] = $searchResults->id;
        } else {
            $params["result_id"] = 0;
        }

        $lastSearchResults = Search::where('user_id', 33)
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
        
        $params["searchId"] = $search->id;

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
 
    
    public function findCityByID($id) {

        $airport = Airport::find($id);

        return $airport->city;
    }

    public function requestQuote(Request $request)
    {
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
        return response()->json($emails);
    }
    
    public function createQuote(Request $request){
        
        return view('client.account.requests.success');
    }
    
    public function sendMail(Request $request)
    {
        //Mail::to('ju.odarjuk@gmail.com')->send('Order status Updated');
        
        Mail::send([], [], function ($message) {
            $message->from('ju.odarjuk@gmail.com', 'Laravel');

            $message->to('ju.odarjuk@gmail.com')->subject("Email Testing with Laravel");
            
            $message->setBody("Dear ...\n\nWe have received your request and will send you the quote in the shortest possible time.\n\nBest regards,\nJetOnset team.");
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
