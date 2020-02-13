<?php

namespace App\Http\Controllers\Api;

use App\Models\Airport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use App\Models\Avinode;
use Carbon\Carbon;

class AvinodeController extends Controller
{
    protected $avinode;

    public function __construct(Avinode $avinode)
    {
        $this->avinode = $avinode;
    }

    public function index(Request $request)
    {
        $date = explode("-", $request->departure);

        $startPoint = $this->findAirport($request->startPoint);
        $endPoint = $this->findAirport($request->endPoint);

        $params["startPoint"] = $startPoint;
        $params["endPoint"] = $endPoint;
        $params["startDate"] = Carbon::parse($date[0])->format('Y-m-d');
        $params["endDate"] = Carbon::parse($date[1])->format('Y-m-d');
        $params["passengers"] = $request->passengers;

        $searchResults = $this->avinode->all($params);

//        return redirect()->route(
//            'requests.request', ['start'=>$startPoint,'end'=>$endPoint,
//                'startDate'=> $params["startDate"], 'endDate'=>$params["endDate"]])->with( ['searchResults' => $searchResults] );
        return view('client.account.requests.request', compact('searchResults'));
    }

    public function findAirport($keyword) {
        $airport = Airport::where('name', 'like', "%{$keyword}%")
                    ->first();
        return $airport->iata;
    }

    public function request()
    {


    }
}
