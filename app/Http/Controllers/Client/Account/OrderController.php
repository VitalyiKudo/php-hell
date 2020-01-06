<?php

namespace App\Http\Controllers\Client\Account;

use Auth;
use App\Models\Order;
use App\Models\Transaction;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Client\OrderPayment as OrderPaymentRequest;

class OrderController extends Controller
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
        $orders = $user->orders()->orderBy('id', 'desc')->get();

        return view('client.account.orders.index', compact('orders'));
    }

    /**
     * Display a booking page for the order.
     *
     * @return \Illuminate\Http\Response
     */
    public function booking(Order $order)
    {
        $user = Auth::user();
        $cards = $user->cards;

        return view('client.account.orders.booking', compact('order', 'cards'));
    }

    /**
     * Process payment for the order.
     *
     * @param  \App\Http\Requests\Client\OrderPayment  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function payment(OrderPaymentRequest $request, Order $order)
    {
        $user = Auth::user();
        $card = $user->cards()->findOrFail($request->input('card_id'));

        $amount = $order->price;

        // Create a new transaction
        $transaction = new Transaction;

        $transaction->is_success = false;
        $transaction->amount = $amount;
        $transaction->user()->associate($user);
        $transaction->order()->associate($order);

        // Charge selected card
        $transactionId = $user->charge($card, $amount);

        if ($transactionId === false) {
            $transaction->save();

            throw ValidationException::withMessages([
                'card_id' => 'Can\'t charge selected card.',
            ]);
        }

        // Update transaction model
        $transaction->is_success = true;
        $transaction->transaction_id = $transactionId;
        $transaction->save();

        return redirect()->route('client.orders.booking', $order->id);
    }
}
