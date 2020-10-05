<?php

namespace App\Http\Controllers\Client\Account;

use App\Models\Airport;
use App\Models\Search;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use App\Models\Avinode;
use Carbon\Carbon;
use App\Models\Order;
use Mail;
use App\Models\Pricing;
use Auth;


class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:client');
    }

    public function index(Request $request)
    {
        
        $date = explode("-", $request->departure);

        $startPoint = $this->findAirport($request->startPoint);
        $endPoint = $this->findAirport($request->endPoint);

        $params["startPointName"] = $request->startPoint;
        $params["endPointnName"] = $request->endPoint;
        $params["startPoint"] = $startPoint;
        $params["endPoint"] = $endPoint;
        $params["startDate"] = Carbon::parse($date[0])->format('Y-m-d');
        $params["endDate"] = Carbon::parse($date[1])->format('Y-m-d');
        $params["date"] = $request->departure;
        $params["passengers"] = $request->passengers;
        $params["userId"] = Auth::user()->id;

        $searchResults = Pricing::where('departure', $request->startPoint)
                ->where('arrival', $request->endPoint)->get();
        
        return view('client.account.requests.request', compact('searchResults', 'params'));
    }
    
    public function findAirport($keyword) {
        $airport = Airport::where('name', 'like', "%{$keyword}%")->first();
        
        return $airport->id;
    }

    public function requestQuote(Request $request)
    {
        $data = [];
        $result_ids = $request->input('result_id');
        $now = Carbon::now();
        
        if(count($result_ids)){
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
        }

        return redirect()
            ->route('client.search.createQuote')
            ->with('status', 'The Quote was successfully added.');
        
    }
    
    public function createQuote(Request $request){
        
        return view('client.account.requests.success');
    }
    
    public function sendMail(Request $request)
    {
        //Mail::to('ju.odarjuk@gmail.com')->send('Order status Updated');
        
        $data = ['name', 'Ripon Uddin Arman'];
        
        Mail::send('client.emails.create_quote', $data, function ($message) {
            $message->from('ju.odarjuk@gmail.com', 'Laravel');

            $message->to('ju.odarjuk@gmail.com')->subject("Email Testing with Laravel");
        });
        
        return "ok";
    }
    
}
