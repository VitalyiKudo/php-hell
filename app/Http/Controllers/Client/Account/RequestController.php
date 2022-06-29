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
        Session::put('pervis_search_url', url()->full());

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

        return view('client.account.requests.index', compact('requests'));
    }

}
