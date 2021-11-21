<?php

namespace App\Http\Controllers\Client\Account;

use Auth;
use App\Models\Order;
use App\Http\Controllers\Controller;
use Session;
use DB;

class RequestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:client');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$user = Auth::user();
        //$requests = $user->orders()->orderBy('id', 'desc')->get();
        //$requests = $user->searches()->orderBy('id', 'desc')->get();

        //$requests = $user->searches()->join('orders', 'searches.id', '=', 'orders.search_result_id')->orderBy('id', 'desc')->paginate(25);
        /*
        $requests = DB::table('searches')
                ->leftJoin('orders', 'searches.id', '=', 'orders.search_result_id')
                ->orderBy('id', 'desc')
                ->paginate(25);
        */

        //$requests = $user->searches()->orderBy('id', 'desc')->paginate(25);

        Session::put('pervis_search_url', url()->full());

        $requests = DB::table('searches')
                ->where(['searches.user_id' => Auth::id(), 'orders.book_status' => 0])
                ->Join('orders', 'searches.id', '=', 'orders.search_result_id')
                ->orderBy('searches.id', 'desc')
                ->paginate(25);

        //echo "<pre>";
        //print_r($requests);
        //echo "</pre>";

        return view('client.account.requests.index', compact('requests'));
    }

}
