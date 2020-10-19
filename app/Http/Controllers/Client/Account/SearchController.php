<?php

namespace App\Http\Controllers\Client\Account;

use App\Models\Airport;
use App\Models\Search;
use App\Models\Airline;
use App\Models\Operator;
use Illuminate\Http\Request;
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
        //$startPoint = $this->findAirport($request->startPoint);
        //$endPoint = $this->findAirport($request->endPoint);
        
        $startCity = $this->findCity($request->startPoint);
        $endCity = $this->findCity($request->endPoint);
        
        $startPoint = $this->findAirport($request->startPoint);
        $endPoint = $this->findAirport($request->endPoint);
        
        //echo $startCity;
        //echo $endCity;

        $params["startPointName"] = $startCity;
        $params["endPointnName"] = $endCity;
        $params["startPoint"] = $startPoint;
        $params["endPoint"] = $endPoint;
        $params["flightDate"] = Carbon::parse($request->flight_date)->format('Y-m-d');
        $params["passengers"] = $request->passengers;
        $params["userId"] = Auth::user()->id;
        /*
        $searchResults = Pricing::where('departure', $request->startPoint)
                ->where('arrival', $request->endPoint)
                ->first();
        */
        
        $searchResults = Pricing::whereRaw("(`departure` like ? OR REPLACE(`departure`, '-', ' ') like ? OR REPLACE(`departure`, '.', '') like ?) AND (`arrival` like ? OR REPLACE(`arrival`, '-', ' ') like ? OR REPLACE(`arrival`, '.', '') like ?)", [$startCity, $startCity, $startCity, $endCity, $endCity, $endCity])->first();
        
        return view('client.account.requests.request', compact('searchResults', 'params'));
    }
    
    public function findAirport($keyword) {
        $airport = Airport::where('name', $keyword)
                ->orWhere('city', $keyword)
                ->first();
        
        return $airport->id;
    }
    
    public function findCity($query) {
        
        $airport = DB::table('airports')
                ->where('name', $query)
                ->orWhere('city', $query)
                ->first();

        //$airport = Airport::find($id);
        return $airport->city;
    }
    
    public function findCityByID($id) {

        $airport = Airport::find($id);

        //$airport = Airport::find($id);
        return $airport->city;
    }

    public function requestQuote(Request $request)
    {

        $search = new Search;

        $search->flight_model = $request->input('flight_model');
        $search->result_id = $request->input('result_id');
        $search->user_id = $request->input('user_id');
        $search->start_airport_id = $request->input('start_airport_id');
        $search->end_airport_id = $request->input('end_airport_id');
        $search->departure_at = $request->input('departure_at');
        $search->pax = $request->input('pax');

        $search->save();
       
        
        Mail::send([], [], function ($message) {
            $user = Auth::user();
            $message->from('quote@jetonset.com', 'JetOnset team');
            //$message->to('ju.odarjuk@gmail.com')->subject("We have received your request");
            $message->to($user->email)->subject("We have received your request");
            $message->setBody("Dear {$user->first_name} {$user->last_name}\n\nWe have received your request and will send you the quote in the shortest possible time.\n\nBest regards,\nJetOnset team.");
        });
         
        

        
        
        
        $operator_list = [];
        $airlines = Airline::where('type', $request->input('flight_model'))->get();
        
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

        //$pax = $request->input('pax');
        //$request->input('departure_at')
        $date = Carbon::parse($request->input('departure_at'))->format('d F Y');
        $airports = [
            'start_city' => $this->findCityByID($request->input('start_airport_id')),
            'end_city' => $this->findCityByID($request->input('end_airport_id')),
        ];
        
        $emails = array_unique($emails);

        foreach($emails as $email){
           
            
            Mail::send([], [], function ($message) use ($email, $request, $date, $airports) {
                $user = Auth::user();
                $message->from($user->email, 'JetOnset team');
                $message->to('ju.odarjuk@gmail.com')->subject("We have received your request");
                //$message->to($email)->subject("We have received your request");
                //$message->setBody("Dear {$user->first_name} {$user->last_name}\n\nWe have received your request and will send you the quote in the shortest possible time.\n\nBest regards,\nJetOnset team.");
                $message->setBody("Dear all!\n\nCan you send me the quote for a flight from {$airports['start_city']} to {$airports['end_city']} on {$date} for a company of {$request->input('pax')} people.\n\nBest regards,\n{$user->first_name} {$user->last_name}\nJetOnset\n{$user->phone_number}");
            });
           
                
        }
       
        

        //return AirportResource::collection($airports);
        return response()->json($emails);
        
        
        
        /*
        $data = [];
        $result_ids = $request->input('result_id');
        $now = Carbon::now();
        $message = 'The Quote was not selected';
        
        //$user = Auth::user();
        
        //echo $user->first_name;
        //echo $user->last_name;
        //echo $user->email;
        
        //exit();
        
        //echo gettype($result_ids);
        //exit();
        
        if($result_ids){
            foreach($result_ids as $result_id){
                $data[] = [
                    'result_id' => $result_id,
                    'user_id' => $request->input('user_id'), 
                    'start_airport_id' => $request->input('start_airport_id'), 
                    'end_airport_id' => $request->input('end_airport_id'), 
                    'departure_at' => $request->input('departure_at'), 
                    'pax' => $request->input('pax'),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            Search::insert($data);

            Mail::send([], [], function ($message) {
                $user = Auth::user();
                $message->from('quote@jetonset.com', 'JetOnset team');
                //$message->to('ju.odarjuk@gmail.com')->subject("We have received your request");
                $message->to($user->email)->subject("We have received your request");
                $message->setBody("Dear {$user->first_name} {$user->last_name}\n\nWe have received your request and will send you the quote in the shortest possible time.\n\nBest regards,\nJetOnset team.");
            });
            
            $message = 'The Quote was successfully added.';
            
        }

        return redirect()
            ->route('client.search.createQuote')
            ->with('status', $message);
        */
        
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
