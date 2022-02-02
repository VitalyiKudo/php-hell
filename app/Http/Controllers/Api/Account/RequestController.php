<?php

namespace App\Http\Controllers\Api\Account;

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
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     * @OA\Get(
     *     path="/api/requests",
     *     description="User data Page",
     *     tags={"Request Quote"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200, 
     *         description="OK",
     *     )
     * )
     * 
     */
    public function index()
    {
        Session::put('pervis_search_url_api', url()->full());
        $pervis_search_url = Session::get('pervis_search_url_api');

        $requests = DB::table('searches')
                ->where(['searches.user_id' => Auth::id(), 'orders.book_status' => 0])
                ->Join('orders', 'searches.id', '=', 'orders.search_result_id')
                ->orderBy('searches.id', 'desc')
                ->paginate(25);

        return response()->json([
            'requests' => $requests,
            'pervis_search_url' => $pervis_search_url,
        ]);
    }

}
