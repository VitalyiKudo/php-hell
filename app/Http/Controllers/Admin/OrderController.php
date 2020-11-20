<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\StoreOrder as StoreOrderRequest;
use App\Http\Requests\Admin\UpdateOrder as UpdateOrderRequest;
use App\Mail\SendMail;
use App\Models\OrderStatus;
use Illuminate\Support\Facades\Mail;
use App\Models\Search;
use App\Models\Pricing;
use App\User;


class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::orderBy('id', 'desc')->paginate(25);
        return view('admin.orders.list', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request   $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $orderStatuses = OrderStatus::all();
        $search = Search::find($order->search_result_id);
        $user = User::find($order->user_id);
        $pricing = Pricing::find($search->result_id);

        return view('admin.orders.view', compact('order','orderStatuses', 'search', 'user', 'pricing'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $orderStatuses = OrderStatus::all();

        return view('admin.orders.edit', compact('order','orderStatuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $order = Order::where('id', $order->id)->first();
        
        $order->order_status_id = $request->order_status;
        $order->price = $request->price;
        $order->save();
        
        //Mail::to($order->user->email)->send(new SendMail($order));
        Mail::send('admin.emails.order_status', ['order' => $order], function ($m) use ($order) {
            $m->from('support@jetonset.com', 'JetOnSet');
            $m->to($order->user->email)->subject('Order status Updated');
        });     
        return redirect()->back()->with('status', 'The order was successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        abort(404);
    }

    /**
     * Updated Order Status.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function orderAccepted(Request $request) {
        $data = Order::where('id', $request->order_id)->first();
        
        $data->is_accepted = $request->input('accept');
        $data->save();

        return redirect()->back()->with('status', 'The order was successfully updated.');
    }
}
