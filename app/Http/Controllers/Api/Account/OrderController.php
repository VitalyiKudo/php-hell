<?php

namespace App\Http\Controllers\Api\Account;

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
// Square
use Square\Environment;
use Dotenv\Dotenv;
use Square\Models\Money;
use Square\Models\CreatePaymentRequest;
use Square\Exceptions\ApiException;
use Square\SquareClient;
use DB;


class OrderController extends Controller
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
     *     path="/api/orders",
     *     description="List of Orders",
     *     tags={"Orders"},
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
        $orders = DB::table('orders')
                ->select('*', 'orders.id as order_id')
                ->where([
                    'orders.user_id' => Auth::id(),
                    'orders.book_status' => 1
                ])
                ->join('searches', 'searches.id', '=', 'orders.search_result_id')
                ->join('order_statuses', 'order_statuses.id', '=', 'orders.order_status_id')
                ->orderBy('orders.id', 'desc')
                ->paginate(25);

        return response()->json([
            'orders' => $orders
        ]);
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

    /**
     *
     * Order step #2
     *
     * @OA\Get(
     *     path="/api/orders/{search}/confirm/{type}",
     *     description="Order step #2",
     *     tags={"Orders"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="search",
     *         description="",
     *         in = "path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="type",
     *         description="",
     *         in = "path",
     *         required=true,
     *         explode=false,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(
     *                 type="string",
     *                 enum = {"turbo", "light", "medium", "heavy"},
     *                 default="turbo",
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     *
     */

    public function confirm(Request $request)
    {
        $session_id = Session::get('session_token_id');

        $search_updates = Search::where('session_id', $session_id)->get();
        if($search_updates){
            foreach ($search_updates as $search_update) {
                $search_update->user_id = Auth::user()->id;
                $search_update->save();
            }
        }


        $pervis_search_url = Session::get('pervis_search_url_api');
        Session::put('pervis_confirm_url_api', url()->full());

        $feeses = Fees::all();

        $user = Auth::user();
        $search_id = $request->route('search');
        $search_type = $request->route('type');

        $search = Search::find($search_id);

        $start_airport_name = $search->start_airport_name;
        $end_airport_name = $search->end_airport_name;
        $departure_at = $search->departure_at;
        $pax = $search->pax;

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

        $total_price = (float)$price;

        foreach($feeses as $fees){

            if($fees->active){

                if($fees->sall){
                    if($fees->type == "$"){
                        $total_price -= $fees->amount;
                    } else {
                        $total_price -= $price * ($fees->amount / 100 );
                    }
                }else{
                    if($fees->type == "$"){
                        $total_price += $fees->amount;
                    } else {
                        $total_price += $price * ($fees->amount / 100 );
                    }
                }

            }
        }

        return response()->json([
            'search_id' => $search_id,
            'search_type' => $search_type,
            'pricing' => $pricing,
            'price' => $price,
            'time' => $time,
            'user' => $user,
            'start_airport_name' => $start_airport_name,
            'end_airport_name' => $end_airport_name,
            'departure_at' => $departure_at,
            'pax' => $pax,
            'feeses' => $feeses,
            'total_price' => $total_price,
            'pervis_search_url' => $pervis_search_url,
        ]);
    }


    /**
     *
     * Order step #3
     *
     * @OA\Get(
     *     path="/api/orders/{search}/square/{type}",
     *     description="Order step #3",
     *     tags={"Orders"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="search",
     *         description="",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="type",
     *         description="",
     *         in="path",
     *         required=true,
     *         explode=false,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(
     *                 type="string",
     *                 enum = {"turbo", "light", "medium", "heavy"},
     *                 default="turbo",
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     *
     * Order step #3
     *
     * @OA\Post(
     *     path="/api/orders/{search}/square/{type}",
     *     description="Order step #3",
     *     tags={"Orders"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="search",
     *         description="",
     *         in = "path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="type",
     *         description="",
     *         in="path",
     *         required=true,
     *         explode=false,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(
     *                 type="string",
     *                 enum = {"turbo", "light", "medium", "heavy"},
     *                 default="turbo",
     *             )
     *         )
     *     ),
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *               type="object",
     *               @OA\Property(
     *                   property="first_name",
     *                   description="First Name",
     *                   type="string",
     *                   example="first name"
     *               ),
     *               @OA\Property(
     *                   property="last_name",
     *                   description="Last Name",
     *                   type="string",
     *                   example="last name"
     *               ),
     *               @OA\Property(
     *                   property="birth_date",
     *                   description="Birth_date",
     *                   type="string",
     *                   example="11/10/1986"
     *               ),
     *               @OA\Property(
     *                   property="is_accepted",
     *                   description="Is accepted",
     *                   type="boolean",
     *                   example="true"
     *               ),
     *               @OA\Property(
     *                   property="gender",
     *                   description="Gender",
     *                   type="string",
     *                   example="gender"
     *               ),
     *               @OA\Property(
     *                   property="title",
     *                   description="Title",
     *                   type="string",
     *                   example="title"
     *               ),
     *               @OA\Property(
     *                   property="comment",
     *                   description="Comment",
     *                   type="string",
     *                   example="comment"
     *               ),
     *               @OA\Property(
     *                   property="nonce",
     *                   description="Is accepted",
     *                   type="string",
     *                   example="GDG574SD57DGSDGSG"
     *               ),
     *           )
     *        )
     *     ),
     *     @OA\RequestBody(
     *       required=false,
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *               type="object",
     *               @OA\Property(
     *                   property="first_name",
     *                   description="First Name",
     *                   type="string",
     *                   example="first name"
     *               ),
     *               @OA\Property(
     *                   property="last_name",
     *                   description="Last Name",
     *                   type="string",
     *                   example="last name"
     *               ),
     *               @OA\Property(
     *                   property="birth_date",
     *                   description="Birth_date",
     *                   type="string",
     *                   example="11/10/1986"
     *               ),
     *               @OA\Property(
     *                   property="is_accepted",
     *                   description="Is accepted",
     *                   type="boolean",
     *                   example="true"
     *               ),
     *               @OA\Property(
     *                   property="gender",
     *                   description="Gender",
     *                   type="string",
     *                   example="gender"
     *               ),
     *               @OA\Property(
     *                   property="title",
     *                   description="Title",
     *                   type="string",
     *                   example="title"
     *               ),
     *               @OA\Property(
     *                   property="comment",
     *                   description="Comment",
     *                   type="string",
     *                   example="comment"
     *               ),
     *               @OA\Property(
     *                   property="nonce",
     *                   description="Is accepted",
     *                   type="string",
     *                   example="GDG574SD57DGSDGSG"
     *               ),
     *           )
     *        )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     *
     */

    public function square(Request $request)
    {
        $pervis_confirm_url = Session::get('pervis_confirm_url_api');
        $post_form_url = url()->full();

        $dotenv = Dotenv::create(base_path());
        $dotenv->load();

        $upper_case_environment = strtoupper(getenv('ENVIRONMENT'));

        $applicationId = getenv($upper_case_environment.'_APP_ID');
        $locationId = getenv($upper_case_environment.'_LOCATION_ID');

        $environment = $_ENV["ENVIRONMENT"];
        $access_token =  getenv($upper_case_environment.'_ACCESS_TOKEN');

        $client = new SquareClient([
            'accessToken' => $access_token,
            'environment' => getenv('ENVIRONMENT')
        ]);


        $feeses = Fees::all();

        $user = Auth::user();
        $search_id = $request->route('search');
        $search_type = $request->route('type');

        $search = Search::find($search_id);

        $start_airport_name = $search->start_airport_name;
        $end_airport_name = $search->end_airport_name;
        $departure_at = Carbon::parse($search->departure_at)->format('d F Y');
        $pax = $search->pax;

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

            if($fees->active){

                if($fees->sall){
                    if($fees->type == "$"){
                        $total_price -= $fees->amount;
                    } else {
                        $total_price -= $price * ($fees->amount / 100 );
                    }
                }else{
                    if($fees->type == "$"){
                        $total_price += $fees->amount;
                    } else {
                        $total_price += $price * ($fees->amount / 100 );
                    }
                }

            }
        }

        $messages = NULL;
        $cart_errors = [];

        $request_method = 'get';

        if ($request->isMethod('post')){

            $request_method = 'post';


            $validator = Validator::make(
                [
                    'first_name' => $request->input('first_name'),
                    'last_name' => $request->input('last_name'),
                    'birth_date' => $request->input('birth_date'),
                    'gender' => $request->input('gender'),
                    'title' => $request->input('title'),
                    'comment' => $request->input('comment'),
                    'is_accepted' => $request->input('is_accepted'),
                ],
                [
                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'birth_date' => 'required|max:255',
                    'is_accepted' => 'required',
                ]
            );

            if ($validator->fails()){
                $messages = $validator->messages();
            } else {

                $nonce = $request->input('nonce');
                if (!is_null($nonce)) {

                    $payments_api = $client->getPaymentsApi();

                    $money = new Money();
                    $money->setAmount($total_price*100);
                    $money->setCurrency('USD');
                    $create_payment_request = new CreatePaymentRequest($nonce, uniqid(), $money);

                    try {
                        $response = $payments_api->createPayment($create_payment_request);
                        // If there was an error with the request we will
                        // print them to the browser screen here
                        if ($response->isError()) {
                            //echo 'Api response has Errors';
                            $errors = $response->getErrors();
                            //echo '<ul>';
                            foreach ($errors as $error) {
                                //echo '<li>❌ ' . $error->getDetail() . '</li>';
                                $cart_errors[] = $error->getDetail();
                            }
                            //echo '</ul>';
                            //exit();

                        }

                        if ($response->isSuccess()) {
                            //Order::where('id', $order->id)->update(['order_status_id' => 3]);

                            $payment = $response->getResult()->getPayment();
                            $payment_id = $payment->getId();

                            $comment = "";
                            $comment .= $request->input('comment') ? "Comment: " . $request->input('comment') . ";\r\n" : "" ;
                            $comment .= $request->input('first_name') ? "First Name: " . $request->input('first_name') . ";\r\n" : "" ;
                            $comment .= $request->input('last_name') ? "Last Name: " . $request->input('last_name') . ";\r\n" : "" ;
                            $comment .= $request->input('birth_date') ? "Birth Date: " . $request->input('birth_date') . ";\r\n" : "" ;
                            $comment .= $request->input('gender') ? "Gender: " . $request->input('gender') . ";\r\n" : "" ;
                            $comment .= $request->input('title') ? "Title: ".$request->input('title').";\r\n" : "" ;
                            $comment .= $request->input('is_accepted') ? "I agree with Cancellation policy: Yes;\r\n" : "" ;

                            $order = new Order;
                            $order->user_id = $user->id;
                            $order->order_status_id = 1;
                            $order->search_result_id = $search_id;
                            $order->comment = $comment;

                            $order->billing_address = '';
                            $order->billing_country = '';
                            $order->billing_city = '';
                            $order->billing_postcode = '';

                            $order->price = $total_price;
                            $order->type = $search_type;
                            $order->payment_id = $payment_id;
                            $order->is_accepted = (bool)$request->input('is_accepted');
                            $order->book_status = 1;
                            $order->save();

                            /*
                            * Mailing start
                            */

                            Mail::send([], [], function ($message) {
                                $user = Auth::user();
                                $message->from('quote@jetonset.com', 'JetOnset team');
                                //$message->to('ju.odarjuk@gmail.com')->subject("We have received your request");
                                $message->to($user->email)->subject("We have received your request");
                                $message->setBody("Dear {$user->first_name} {$user->last_name}\n\nWe have received your payment and our manager will contact you to discuss all your flight details in the shortest possible time.\n\nBest regards,\nJetOnset team.");
                            });

                            $airport_list = [];
                            $airport_items = Airport::whereIn('name', [$start_airport_name, $end_airport_name])->get();
                            //$airport_items = Airport::whereIn('city', [$start_airport_name])->get();
                            foreach($airport_items as $airport_item){
                                if($airport_item->icao){
                                    $airport_list[] = $airport_item->icao;
                                }
                            }
                            $airport_list = array_unique($airport_list);

                            $operator_list = [];
                            //$airlines = Airline::where('category', $search_type)->whereIn('homebase', $airport_list)->get();
                            $airlines = Airline::where('homebase', $airport_list)->get();

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
                                'start_city' => $start_airport_name,
                                'end_city' => $end_airport_name,
                                'pax' => $pax,
                                'type' => $search_type,
                            ];

                            $date = $departure_at;

                            foreach($emails as $email){
                                Mail::send([], [], function ($message) use ($email, $request, $date, $airports) {
                                    $user = Auth::user();
                                    $message->from($user->email, 'JetOnset team');
                                    //$message->to('zyoga13@gmail.com')->subject("We have request for you!");
                                    $message->to($email)->subject("We have request for you #{$request->input('search_result_id')}");
                                    //$message->to($user->email)->subject("We have received your request");
                                    $message->setBody("Dear all!\n\nCan you send me the quote for a flight from {$airports['start_city']} to {$airports['end_city']} on {$date} for a company of {$airports['pax']} people.\n\nBest regards,\n{$user->first_name} {$user->last_name}\nJetOnset\n{$user->phone_number}");
                                });
                            }

                           /*
                            * Mailing end
                            */

                            return response()->json([
                                'order_id' => $order->id,
                                'order' => Order::Find($order->id),
                                'search' => Search::Find($order->search_result_id),
                                'search_type' => $search_type,
                                'time' => $time,
                                'pricing' => $pricing,
                            ]);

                            //return redirect()->route('client.orders.succeed', ['order_id' => $order->id, $search_type]);

                        }
                        /*
                        echo '<pre>';
                        print_r($response);
                        echo '</pre>';
                        */
                    } catch (ApiException $e) {
                        /*
                        echo 'Caught exception!<br/>';
                        echo('<strong>Response body:</strong><br/>');
                        echo '<pre>'; var_dump($e->getResponseBody()); echo '</pre>';
                        echo '<br/><strong>Context:</strong><br/>';
                        echo '<pre>'; var_dump($e->getContext()); echo '</pre>';
                        exit();
                        */
                    }

                }


            }

        }

        $params = [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'birth_date' => $request->input('birth_date'),
            'gender' => $request->input('gender'),
            'title' => $request->input('title'),
            'comments' => $request->input('comments'),
            'is_accepted' => $request->input('is_accepted'),
        ];

        return response()->json([
            'messages' => $messages,
            'upper_case_environment' => $upper_case_environment,
            'environment' => $environment,
            'applicationId' => $applicationId,
            'locationId' => $locationId,
            'search_id' => $search_id,
            'search_type' => $search_type,
            'pricing' => $pricing,
            'price' => $price,
            'time' => $time,
            'user' => $user,
            'start_airport_name' => $start_airport_name,
            'end_airport_name' => $end_airport_name,
            'departure_at' => $departure_at,
            'pax' => $pax,
            'feeses' => $feeses,
            'total_price' => $total_price,
            'params' => $params,
            'request_method' => $request_method,
            'cart_errors' => $cart_errors,
            'pervis_confirm_url' => $pervis_confirm_url,
            'post_form_url' => $post_form_url,
        ]);

    }

    /**
     *
     * Order step #2
     *
     * @OA\Get(
     *     path="/api/orders/{search}/confirm",
     *     description="Order step #2",
     *     tags={"Orders"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="search",
     *         description="",
     *         in = "path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     *
     */

    public function requestConfirm(Request $request)
    {
        $session_id = Session::get('session_token_id');
        $search_updates = Search::where('session_id', $session_id)->get();
        if($search_updates){
            foreach ($search_updates as $search_update) {
                $search_update->user_id = Auth::user()->id;
                $search_update->save();
            }
        }

        $pervis_search_url = Session::get('pervis_search_url_api');
        Session::put('pervis_confirm_url', url()->full());

        $feeses = Fees::all();

        $user = Auth::user();
        $search_id = $request->route('search');
        $search_type = $request->route('type');


        $search = Search::find($search_id);
        $order = Order::where('search_result_id', $search_id)->first();

        if($order->order_status_id != 2 || $order->price <= 0){
            //return redirect($pervis_search_url);
            return response()->json([
                'message' => 'Your order status is not in process or order price equal 0. You must return to the previous url.',
                'pervis_confirm_url' => $pervis_confirm_url,
            ], 302);
        }

        $start_airport_name = $search->start_airport_name;
        $end_airport_name = $search->end_airport_name;
        $departure_at = Carbon::parse($search->departure_at)->format('d F Y');
        $pax = $search->pax;

        $pricing = Pricing::find($search->result_id);

        $price = $order->price;
        $time = "00:00";


        $total_price = (float)$price;

        foreach($feeses as $fees){

            if($fees->active){

                if($fees->sall){
                    if($fees->type == "$"){
                        $total_price -= $fees->amount;
                    } else {
                        $total_price -= $price * ($fees->amount / 100 );
                    }
                }else{
                    if($fees->type == "$"){
                        $total_price += $fees->amount;
                    } else {
                        $total_price += $price * ($fees->amount / 100 );
                    }
                }

            }
        }

        return response()->json([
            'search_id' => $search_id,
            'search_type' => $search_type,
            'pricing' => $pricing,
            'price' => $price,
            'time' => $time,
            'user' => $user,
            'start_airport_name' => $start_airport_name,
            'end_airport_name' => $end_airport_name,
            'departure_at' => $departure_at,
            'pax' => $pax,
            'feeses' => $feeses,
            'total_price' => $total_price,
            'pervis_search_url' => $pervis_search_url,
        ]);

    }

    /**
     *
     * Order step #3
     *
     * @OA\Get(
     *     path="/api/orders/{search}/square",
     *     description="Order step #3",
     *     tags={"Orders"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="search",
     *         description="",
     *         in = "path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     *
     * Order step #3
     *
     * @OA\Post(
     *     path="/api/orders/{search}/square",
     *     description="Step #3",
     *     tags={"Orders"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="search",
     *         description="",
     *         in = "path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *               type="object",
     *               @OA\Property(
     *                   property="first_name",
     *                   description="First Name",
     *                   type="string",
     *                   example="first name"
     *               ),
     *               @OA\Property(
     *                   property="last_name",
     *                   description="Last Name",
     *                   type="string",
     *                   example="last name"
     *               ),
     *               @OA\Property(
     *                   property="birth_date",
     *                   description="Birth_date",
     *                   type="string",
     *                   example="11/10/1986"
     *               ),
     *               @OA\Property(
     *                   property="is_accepted",
     *                   description="Is accepted",
     *                   type="boolean",
     *                   example="true"
     *               ),
     *               @OA\Property(
     *                   property="gender",
     *                   description="Gender",
     *                   type="string",
     *                   example="gender"
     *               ),
     *               @OA\Property(
     *                   property="title",
     *                   description="Title",
     *                   type="string",
     *                   example="title"
     *               ),
     *               @OA\Property(
     *                   property="comment",
     *                   description="Comment",
     *                   type="string",
     *                   example="comment"
     *               ),
     *               @OA\Property(
     *                   property="nonce",
     *                   description="Is accepted",
     *                   type="string",
     *                   example="GDG574SD57DGSDGSG"
     *               ),
     *           )
     *        )
     *     ),
     *     @OA\RequestBody(
     *       required=false,
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *               type="object",
     *               @OA\Property(
     *                   property="first_name",
     *                   description="First Name",
     *                   type="string",
     *                   example="first name"
     *               ),
     *               @OA\Property(
     *                   property="last_name",
     *                   description="Last Name",
     *                   type="string",
     *                   example="last name"
     *               ),
     *               @OA\Property(
     *                   property="birth_date",
     *                   description="Birth_date",
     *                   type="string",
     *                   example="11/10/1986"
     *               ),
     *               @OA\Property(
     *                   property="is_accepted",
     *                   description="Is accepted",
     *                   type="boolean",
     *                   example="true"
     *               ),
     *               @OA\Property(
     *                   property="gender",
     *                   description="Gender",
     *                   type="string",
     *                   example="gender"
     *               ),
     *               @OA\Property(
     *                   property="title",
     *                   description="Title",
     *                   type="string",
     *                   example="title"
     *               ),
     *               @OA\Property(
     *                   property="comment",
     *                   description="Comment",
     *                   type="string",
     *                   example="comment"
     *               ),
     *               @OA\Property(
     *                   property="nonce",
     *                   description="Is accepted",
     *                   type="string",
     *                   example="GDG574SD57DGSDGSG"
     *               ),
     *           )
     *        )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     *
     */

    public function requestSquare(Request $request)
    {
        $pervis_confirm_url = Session::get('pervis_confirm_url_api');
        $post_form_url = url()->full();

        $dotenv = Dotenv::create(base_path());
        $dotenv->load();

        $upper_case_environment = strtoupper(getenv('ENVIRONMENT'));

        $applicationId = getenv($upper_case_environment.'_APP_ID');
        $locationId = getenv($upper_case_environment.'_LOCATION_ID');

        $environment = $_ENV["ENVIRONMENT"];
        $access_token =  getenv($upper_case_environment.'_ACCESS_TOKEN');

        $client = new SquareClient([
            'accessToken' => $access_token,
            'environment' => getenv('ENVIRONMENT')
        ]);


        $feeses = Fees::all();

        $user = Auth::user();
        $search_id = $request->route('search');
        $search_type = "";

        $search = Search::find($search_id);
        $order = Order::where('search_result_id', $search_id)->first();

        if($order->order_status_id != 2 || $order->price <= 0){
            //return redirect($pervis_confirm_url);
            return response()->json([
                'message' => 'Your order status is not in process or order price equal 0. You must return to the previous url.',
                'pervis_confirm_url' => $pervis_confirm_url,
            ], 302);
        }

        $start_airport_name = $search->start_airport_name;
        $end_airport_name = $search->end_airport_name;
        $departure_at = Carbon::parse($search->departure_at)->format('d F Y');
        $pax = $search->pax;

        $pricing = Pricing::find($search->result_id);

        $price = $order->price;
        $time = "00:00";

        $total_price = $price;

        foreach($feeses as $fees){

            if($fees->active){

                if($fees->sall){
                    if($fees->type == "$"){
                        $total_price -= $fees->amount;
                    } else {
                        $total_price -= $price * ($fees->amount / 100 );
                    }
                }else{
                    if($fees->type == "$"){
                        $total_price += $fees->amount;
                    } else {
                        $total_price += $price * ($fees->amount / 100 );
                    }
                }

            }
        }

        $messages = NULL;
        $cart_errors = [];

        $request_method = 'get';

        if ($request->isMethod('post')){

            $request_method = 'post';


            $validator = Validator::make(
                [
                    'first_name' => $request->input('first_name'),
                    'last_name' => $request->input('last_name'),
                    'birth_date' => $request->input('birth_date'),
                    'gender' => $request->input('gender'),
                    'title' => $request->input('title'),
                    'comment' => $request->input('comment'),
                    'is_accepted' => $request->input('is_accepted'),
                ],
                [
                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'birth_date' => 'required|max:255',
                    'is_accepted' => 'required',
                ]
            );


            if ($validator->fails()){
                $messages = $validator->messages();
            } else {

                $nonce = $request->input('nonce');
                if (!is_null($nonce)) {

                    $payments_api = $client->getPaymentsApi();

                    $money = new Money();
                    $money->setAmount($total_price*100);
                    $money->setCurrency('USD');

                    $create_payment_request = new CreatePaymentRequest($nonce, uniqid(), $money);

                    try {

                        $response = $payments_api->createPayment($create_payment_request);

                        if ($response->isError()) {
                            $errors = $response->getErrors();
                            foreach ($errors as $error) {
                                $cart_errors[] = $error->getDetail();
                            }


                        }
                        if ($response->isSuccess()) {

                            $payment = $response->getResult()->getPayment();
                            $payment_id = $payment->getId();

                            $comment = "";
                            $comment .= $request->input('comment') ? "Comment: " . $request->input('comment') . ";\r\n" : "" ;
                            $comment .= $request->input('first_name') ? "First Name: " . $request->input('first_name') . ";\r\n" : "" ;
                            $comment .= $request->input('last_name') ? "Last Name: " . $request->input('last_name') . ";\r\n" : "" ;
                            $comment .= $request->input('birth_date') ? "Birth Date: " . $request->input('birth_date') . ";\r\n" : "" ;
                            $comment .= $request->input('gender') ? "Gender: " . $request->input('gender') . ";\r\n" : "" ;
                            $comment .= $request->input('title') ? "Title: ".$request->input('title').";\r\n" : "" ;
                            $comment .= $request->input('is_accepted') ? "I agree with Cancellation policy: Yes;\r\n" : "" ;

                            $order = Order::find($order->id);
                            $order->user_id = $user->id;
                            $order->order_status_id = 7;
                            $order->comment = $order->comment ."\r\n". $comment;

                            $order->billing_address = '';
                            $order->billing_country = '';
                            $order->billing_city = '';
                            $order->billing_postcode = '';

                            $order->price = $total_price;
                            $order->payment_id = $payment_id;
                            $order->is_accepted = (bool)$request->input('is_accepted');
                            $order->book_status = 1;
                            $order->save();

                            /*
                            * Mailing start
                            */

                            Mail::send([], [], function ($message) {
                                $user = Auth::user();
                                $message->from('quote@jetonset.com', 'JetOnset team');
                                //$message->to('ju.odarjuk@gmail.com')->subject("We have received your request");
                                $message->to($user->email)->subject("We have received your request");
                                $message->setBody("Dear {$user->first_name} {$user->last_name}\n\nWe have received your payment and our manager will contact you to discuss all your flight details in the shortest possible time.\n\nBest regards,\nJetOnset team.");
                            });

                            $airport_list = [];
                            $airport_items = Airport::whereIn('city', [$start_airport_name, $end_airport_name])->get();
                            foreach($airport_items as $airport_item){
                                if($airport_item->icao){
                                    $airport_list[] = $airport_item->icao;
                                }
                            }
                            $airport_list = array_unique($airport_list);

                            $operator_list = [];
                            $airlines = Airline::where('category', $search_type)->whereIn('homebase', $airport_list)->get();

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
                                'start_city' => $start_airport_name,
                                'end_city' => $end_airport_name,
                                'pax' => $pax,
                                'type' => $search_type,
                            ];

                            $date = $departure_at;

                            foreach($emails as $email){
                                Mail::send([], [], function ($message) use ($email, $request, $date, $airports) {
                                    $user = Auth::user();
                                    $message->from($user->email, 'JetOnset team');

                                    $message->to($email)->subject("We have request for you #{$request->input('search_result_id')}");

                                    $message->setBody("Dear all!\n\nCan you send me the quote for a flight from {$airports['start_city']} to {$airports['end_city']} on {$date} for a company of {$airports['pax']} people for " . ucfirst($airports['type']) . " class of airplane.\n\nBest regards,\n{$user->first_name} {$user->last_name}\nJetOnset\n{$user->phone_number}");
                                });
                            }

                           /*
                            * Mailing end
                            */

                            /*
                            $order_id = $order->id;
                            $orders = Order::Find($order_id);
                            $search = Search::Find($order->search_result_id);
                            $time = "00:00";
                            */

                            return response()->json([
                                'order_id' => $order->id,
                                'order' => $order,
                                'search' => Search::Find($order->search_result_id),
                                'time' => "00:00",
                            ]);

                            //return redirect()->route('client.orders.request_succeed', $order->id);
                        }

                    } catch (ApiException $e) {
                        /*
                        echo 'Caught exception!<br/>';
                        echo('<strong>Response body:</strong><br/>');
                        echo '<pre>'; var_dump($e->getResponseBody()); echo '</pre>';
                        echo '<br/><strong>Context:</strong><br/>';
                        echo '<pre>'; var_dump($e->getContext()); echo '</pre>';
                        exit();
                        */
                    }

                }


            }

        }


        $params = [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'birth_date' => $request->input('birth_date'),
            'gender' => $request->input('gender'),
            'title' => $request->input('title'),
            'comments' => $request->input('comments'),
            'is_accepted' => $request->input('is_accepted'),
        ];


        return response()->json([
            'search_id' => $search_id,
            'messages' => $messages,
            'upper_case_environment' => $upper_case_environment,
            'environment' => $environment,
            'applicationId' => $applicationId,
            'locationId' => $locationId,
            'search_id' => $search_id,
            'search_type' => $search_type,
            'pricing' => $pricing,
            'price' => $price,
            'time' => $time,
            'user' => $user,
            'start_airport_name' => $start_airport_name,
            'end_airport_name' => $end_airport_name,
            'departure_at' => $departure_at,
            'pax' => $pax,
            'feeses' => $feeses,
            'total_price' => $total_price,
            'params' => $params,
            'request_method' => $request_method,
            'cart_errors' => $cart_errors,
            'pervis_confirm_url' => $pervis_confirm_url,
            'post_form_url' => $post_form_url,
        ]);

    }

    public function succeed(Request $request)
    {
        $order_id = $request->route('order_id');
        $search_type = $request->route('type');
        $order = Order::Find($order_id);
        $search = Search::Find($order->search_result_id);
        $pricing = Pricing::find($search->result_id);

        if($search_type == 'turbo'){
            $time = $pricing->time_turbo;
        } elseif($search_type == 'light'){
            $time = $pricing->time_light;
        } elseif($search_type == 'medium'){
            $time = $pricing->time_medium;
        } elseif($search_type == 'heavy'){
            $time = $pricing->time_heavy;
        } else {
            $time = "00:00";
        }

        return view('client.account.orders.succeed', compact('order_id', 'order', 'search', 'search_type', 'time', 'pricing'));
    }


    public function request_succeed(Request $request)
    {
        $order_id = $request->route('order_id');
        $search_type = $request->route('type');
        $order = Order::Find($order_id);
        $search = Search::Find($order->search_result_id);
        $time = "00:00";

        return view('client.account.orders.request_succeed', compact('order_id', 'order', 'search', 'search_type', 'time'));
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
            $order->book_status = 1;
            $order->save();

            Mail::send([], [], function ($message) {
                $user = Auth::user();
                $message->from('quote@jetonset.com', 'JetOnset team');
                //$message->to('ju.odarjuk@gmail.com')->subject("We have received your request");
                $message->to($user->email)->subject("We have received your request");
                $message->setBody("Dear {$user->first_name} {$user->last_name}\n\nWe have received your request and will send you the quote in the shortest possible time.\nFor details and status of your request please use the link:\nhttps://jetonset.com/requests\n\nBest regards,\nJetOnset team.");
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
