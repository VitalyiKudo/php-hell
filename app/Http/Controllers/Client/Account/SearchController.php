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
        /*
        $startPoint = $this->findAirport($request->startPoint);
        $endPoint = $this->findAirport($request->endPoint);
        */
        
        $startCity = $this->findCity($request->startPoint);
        $endCity = $this->findCity($request->endPoint);

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

        return view('client.account.requests.request', compact('searchResults', 'params', 'messages'));
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
    
    
    
    
    
    /*
    public function attributes()
    {
        return [
            'startPoint' => 'email address',
        ];
    }
    
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'startPoint' => 'required|max:255',
            'endPoint' => 'required|max:255',
            'flight_date' => 'required|date',
            'passengers' => 'required|numeric',
        ]);
        \App\Models\Search::create($validatedData);

        return response()->json('Form is successfully validated and data has been saved');
    }
    
    
    public function messages()
    {
        return [
            'startPoint.required' => 'A title is required',
            'endPoint.required' => 'A message is required',
            'flight_date.required' => 'A title is required',
            'flight_date.required' => 'A message is required',
        ];
    }
    */
    
    
    
    
    public function findCityByID($id) {

        $airport = Airport::find($id);

        //$airport = Airport::find($id);
        return $airport->city;
    }

    public function requestQuote(Request $request)
    {
        /*
        $search = new Search;

        $search->flight_model = $request->input('flight_model');
        $search->result_id = $request->input('result_id');
        $search->user_id = $request->input('user_id');
        $search->start_airport_id = $request->input('start_airport_id');
        $search->end_airport_id = $request->input('end_airport_id');
        $search->departure_at = $request->input('departure_at');
        $search->pax = $request->input('pax');

        $search->save();
        */
        
        
        
        
        $search = new Order;
        $search->user_id = $request->input('user_id');
        $search->order_status_id = 5;
        $search->search_result_id = $request->input('result_id');
        $search->comment = $request->input('comment');
        $search->type = $request->input('flight_model');
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
            'start_city' => $request->input('start_airport_name'),
            'end_city' => $request->input('end_airport_name'),
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
