<?php

namespace App\Http\Controllers\Client\Account;

use Auth;
use App\Models\Order;
use App\Models\Airport;
use App\Models\Airline;
use App\Models\Operator;
use App\Models\Fees;
use Mail;
use App\Models\Transaction;
use App\Models\Search;
use App\Models\Pricing;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Http\Requests\Client\OrderPayment as OrderPaymentRequest;
use \Validator;
use Session;
use Carbon\Carbon;


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

    public function confirm(Request $request)
    {
        /*
        $user = Auth::user();
        echo $user->id;
        echo $user->email;
        */

        //echo \Request::route()->getName();
        //Fees
        $feeses = Fees::all();
        
        $user = Auth::user();
        $search_id = $request->route('search');
        $search_type = $request->route('type');

        $search = Search::find($search_id);
        
        $start_airport_name = $search->start_airport_name;
        $end_airport_name = $search->end_airport_name;
        $departure_at = Carbon::parse($search->departure_at)->format('d F Y');
        $pax = $search->pax;
        
        //echo "<pre>";
        //print_r($search);
        //echo $search->start_airport_name;
        //echo $search->end_airport_name;
        //echo Carbon::parse($search->departure_at)->format('d F Y');
        //echo "</pre>";

        $pricing = Pricing::find($search->result_id);

        if($search_type == 'turbo'){
            $price = $pricing->price_turbo;
            $time = $pricing->time_turbo;
        } elseif($search_type == 'light'){
            $price = $pricing->price_light;
            $time = $pricing->time_light;
        } elseif($search_type == 'medium'){
            $price = $pricing->price_medium;
            $time = $pricing->time_medium;
        } elseif($search_type == 'heavy'){
            $price = $pricing->price_heavy;
            $time = $pricing->time_heavy;
        } else {
            $price = 0.00;
            $time = "00:00";
        }

        
        $total_price = $price;

        foreach($feeses as $fees){
            
            if($fees->active == 1){
                if($fees->type == "$"){
                    $total_price += $fees->amount;
                } else {
                    $total_price += $price * ($fees->amount / 100 );
                }
                
            }
        }

        return view('client.account.orders.confirm', compact('search_id', 'search_type', 'pricing', 'price', 'time', 'user', 'start_airport_name', 'end_airport_name', 'departure_at', 'pax', 'feeses', 'total_price'));
    }

    public function checkout(Request $request)
    {
        $validator = Validator::make(
            [
                'comment' => $request->input('comment'),
                'billing_address' => $request->input('billing_address'),
                'billing_address_secondary' => $request->input('billing_address_secondary'),
                'billing_country' => $request->input('billing_country'),
                'billing_city' => $request->input('billing_city'),
                'billing_province' => $request->input('billing_province'),
                'billing_postcode' => $request->input('billing_postcode'),
                'is_accepted' => $request->input('is_accepted'),
            ],
            [
                'billing_address' => 'required|max:255',
                'billing_country' => 'required|max:255',
                'billing_city' => 'required|max:255',
                'billing_province' => 'required|max:255',
                'billing_postcode' => 'required|numeric',
                'is_accepted' => 'required',
            ]
        );

        $messages = NULL;
        if ($validator->fails()){
            $messages = $validator->messages();
        } else {

            $user = Auth::user();

            $order = new Order;
            $order->user_id = $user->id;
            $order->order_status_id = 2;
            $order->search_result_id = $request->input('search_result_id');
            $order->comment = $request->input('comment');
            $order->price = $request->input('price');
            $order->billing_address = $request->input('billing_address');
            $order->billing_address_secondary = $request->input('billing_address_secondary');
            $order->billing_country = $request->input('billing_country');
            $order->billing_city = $request->input('billing_city');
            $order->billing_province = $request->input('billing_province');
            $order->billing_postcode = $request->input('billing_postcode');
            $order->type = $request->input('type');
            $order->is_accepted = (bool)$request->input('is_accepted');
            $order->save();

            Mail::send([], [], function ($message) {
                $user = Auth::user();
                $message->from('quote@jetonset.com', 'JetOnset team');
                //$message->to('ju.odarjuk@gmail.com')->subject("We have received your request");
                $message->to($user->email)->subject("We have received your request");
                $message->setBody("Dear {$user->first_name} {$user->last_name}\n\nWe have received your request and will send you the quote in the shortest possible time.\n\nBest regards,\nJetOnset team.");
            });
            
            $airport_list = [];
            $airport_items = Airport::whereIn('city', [$request->input('start_airport_name'), $request->input('end_airport_name')])->get();
            foreach($airport_items as $airport_item){
                if($airport_item->icao){
                    $airport_list[] = $airport_item->icao;
                }
            }
            $airport_list = array_unique($airport_list);


            $operator_list = [];
            $airlines = Airline::where('category', $request->input('type'))->whereIn('homebase', $airport_list)->get();

            foreach($airlines as $airline){
                $operator_list[] = $airline->operator;
            }
            $operator_list = array_unique($operator_list);


            $emails = [];
            $operators = Operator::whereIn('name', $operator_list)->get();
            foreach($operators as $operator){
                if ($operator->email == trim($operator->email) && strpos($operator->email, ' ') !== false) {
                    $mail_list = explode(" ", $operator->email);
                    foreach($mail_list as $mail){
                        $emails[] = trim($mail);
                    }
                    $mail_list = [];
                } else if(strstr($operator->email, PHP_EOL)) {
                    $mail_list = explode(PHP_EOL, $operator->email);
                    foreach($mail_list as $mail){
                        $emails[] = trim($mail);
                    }
                    $mail_list = [];
                } else {
                    $emails[] = trim($operator->email);
                }
            }

            $emails = array_unique($emails);
            
            $airports = [
                'start_city' => $request->input('start_airport_name'),
                'end_city' => $request->input('end_airport_name'),
            ];
            
            $date = $request->input('departure_at');
            
            foreach($emails as $email){
                Mail::send([], [], function ($message) use ($email, $request, $date, $airports) {
                    $user = Auth::user();
                    $message->from($user->email, 'JetOnset team');
                    //$message->to('ju.odarjuk@gmail.com')->subject("We have received your request");
                    $message->to($email)->subject("We have request for you #{$request->input('search_result_id')}");
                    //$message->to($user->email)->subject("We have received your request");
                    $message->setBody("Dear all!\n\nCan you send me the quote for a flight from {$airports['start_city']} to {$airports['end_city']} on {$date} for a company of {$request->input('pax')} people for " . ucfirst($request->input('type')) . " class of airplane.\n\nBest regards,\n{$user->first_name} {$user->last_name}\nJetOnset\n{$user->phone_number}");
                });
            }
            

        }
        
        
        if (!$validator->fails()){
            $order_id = $order->id;
            return redirect()->route('client.orders.complete', $order_id);
        } else {
            return redirect()->back()->with(['messages' => $messages])->withInput();
        }

        
    }


    public function checkoutComplete(Request $request)
    {
        $order_id = $request->route('order_id');
        $order = Order::find($order_id);
        $search = Search::find($order->search_result_id);
        $user = Auth::user();

        return view('client.account.orders.complete', compact('order', 'search', 'user'));
    }


    public function orderAccepted(Request $request) {
        $data = Order::where('id', $request->order_id)->first();

        $data->is_accepted = $request->input('accept');
        $data->save();

        return redirect()->back()->with('status', 'The order was successfully updated.');
    }

    
}
