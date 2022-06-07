<?php

namespace App\Http\Controllers\Client\Account;

use App\Models\Search;
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
/*
        $requests1 = DB::table('searches')
                ->where(['searches.user_id' => Auth::id(), 'orders.book_status' => 0])
                ->Join('orders', 'searches.id', '=', 'orders.search_result_id')
                ->orderBy('searches.id', 'desc')
                ->paginate(25);
*/
        $requests = Order::with('searches', 'searches.departureCity', 'searches.arrivalCity')
            ->where(function ($query) {
                $query->where('book_status', 0)
                    ->whereHas('searches', function ($query) {
                        $query->where('user_id', Auth::user()->id);
                    });
            })
            ->orderBy('id', 'desc')
            ->get()
            ->paginate(25);

dd($requests);
        return view('client.account.requests.index', compact('requests'));
    }

}
