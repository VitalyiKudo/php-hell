<?php

namespace App\Http\Controllers\Client\Account;

use Auth;
use App\Models\Order;
use App\Http\Controllers\Controller;

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
        $user = Auth::user();
        $requests = $user->orders()->orderBy('id', 'desc')->get();

        return view('client.account.requests.index', compact('requests'));
    }
}
