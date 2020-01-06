<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\Order;
use App\Models\Search;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $searchesCount = Search::count();
        $usersCount = User::count();
        $earningsAmount = Order::whereHas('status', function ($query) {
            $query->where('code', 'completed');
        })->sum('price');

        return view('admin.dashboard', compact('searchesCount', 'usersCount',  'earningsAmount'));
    }
}
