<?php

namespace App\Http\Controllers\Api\Account;

use App\Models\City;
use App\Models\OperatorCity;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\OrderPayment as OrderPaymentRequest;
use App\Jobs\SendEmailOperator;
use App\Traits\PaymentSquareTrait;

use App\Models\EmptyLeg;
use App\Models\Order;
use App\Models\Airport;
use App\Models\Airline;
use App\Models\Operator;
use App\Models\Fees;
use App\Models\Transaction;
use App\Models\Search;
use App\Models\Pricing;
use App\Models\OrderStatus;

use Validator;
use Session;
use Carbon;
use Auth;
use Config;
#use Mail;
#use Str;
#use DB;
// Square
use Square\Environment;
use Dotenv\Dotenv;
use Square\Models\Money;
use Square\Models\CreatePaymentRequest;
use Square\Exceptions\ApiException;
use Square\SquareClient;

class OrderController extends Controller
{
    use PaymentSquareTrait;

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
     * @param Request $request
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
/*
        $search_updates = Search::where('session_id', $session_id)->get();
        if($search_updates){
            foreach ($search_updates as $search_update) {
                $search_update->user_id = Auth::user()->id;
                $search_update->save();
            }
        }
*/

        $search = new Search;
        $search->result_id = $request->result_id;
        $search->user_id = Auth::check() ? Auth::user()->id : NULL;
        $search->session_id = $session_id;
        $search->start_airport_name = $request->startAirport;
        $search->end_airport_name = $request->endAirport;
        $search->departure_geoId = $request->startPoint;
        $search->arrival_geoId = $request->endPoint;
        $search->departure_at = Carbon::parse($request->departure_at)->format('Y-m-d');
        $search->pax = $request->passengers > 0 ? $request->passengers : 0;
        $search->save();

        $pervis_search_url = Session::get('pervis_search_url');
        Session::put('pervis_confirm_url', url()->full());

        $user = Auth::user();
        $search_id = $search->id;
        $search_type = $request->type;
        $pax = $search->pax;
/*
        if ($search_type !== 'emptyLeg') {
            $search = Search::with('price', 'departureCity', 'arrivalCity')->find($search_id);
        }
        else {
            $search = EmptyLeg::with('departureCity', 'arrivalCity')->find($search->result_id);
        }
        */
        if ($search_type !== 'emptyLeg') {
            $search = Search::with('price', 'departureCity', 'arrivalCity', 'airportDeparture', 'airportArrival')->find($search_id);
            $strPrice = 'price_'.$search_type;
            $total_price = $search->price->$strPrice;
        }
        else {
            $search = EmptyLeg::with('departureCity', 'arrivalCity', 'airportDeparture', 'airportArrival')->find($search->result_id);
            $total_price = $search->price;
        }

        $time_type = 'time_' . $search_type;

        return response()->json([
            'search_id' => $search_id,
            'search_type' => $search_type,
            'pricing' => $total_price,
            'price' => $total_price,
            'time' => !empty($search->price->$time_type) ? $search->price->$time_type : '-',
            'user' => $user,
            'start_airport_name' => $search->airportDeparture->icao,
            'end_airport_name' => $search->airportArrival->icao,
            'departure_at' => !empty($search->departure_at) ? $search->departure_at : $search->date_departure,
            #'pax' => !empty($search->pax) ? $search->pax : Config::get("constants.plane.type_plane.$search->type_plane.feature_plane.Passengers"),
            'pax' => $pax,
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

    public function square(Request $request, Order $order, Transaction $transaction, OrderStatus $orderStatus)
    {
        $pervis_confirm_url = Session::get('pervis_confirm_url');

        $dotenv = Dotenv::create(base_path());
        $dotenv->load();

        $upper_case_environment = strtoupper(getenv('ENVIRONMENT'));

        $applicationId = getenv($upper_case_environment.'_APP_ID');
        $locationId = getenv($upper_case_environment.'_LOCATION_ID');

        $environment = $_ENV["ENVIRONMENT"];
        $access_token =  getenv($upper_case_environment.'_ACCESS_TOKEN');

        $user = Auth::user();
        $search_id = $request->route('search');
        $search_type = $request->route('type');

        if ($search_type !== 'emptyLeg') {
            $search = Search::with('price', 'departureCity', 'arrivalCity', 'departureCity.regionCountry', 'arrivalCity.regionCountry',  'airportDeparture', 'airportArrival')->find($search_id);
            $strPrice = 'price_'.$search_type;
            $total_price = $search->price->$strPrice;
            $operatorCity = array_unique([$search->departure_geoId, $search->arrival_geoId, $search->airportDeparture->geoNameIdCity, $search->airportArrival->geoNameIdCity]);
        }
        else {
            $search = EmptyLeg::with('departureCity', 'arrivalCity', 'departureCity.regionCountry', 'arrivalCity.regionCountry', 'airportDeparture', 'airportArrival', 'operatorData')->find($search_id);
            $total_price = $search->price;
            $operatorCity = [];
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
                    $comment = "";
                    $comment .= $request->input('comment') ? "Comment: " . $request->input('comment') . ";\r\n" : "" ;
                    $comment .= $request->input('first_name') ? "First Name: " . $request->input('first_name') . ";\r\n" : "" ;
                    $comment .= $request->input('last_name') ? "Last Name: " . $request->input('last_name') . ";\r\n" : "" ;
                    $comment .= $request->input('birth_date') ? "Birth Date: " . $request->input('birth_date') . ";\r\n" : "" ;
                    $comment .= $request->input('gender') ? "Gender: " . $request->input('gender') . ";\r\n" : "" ;
                    $comment .= $request->input('title') ? "Title: ".$request->input('title').";\r\n" : "" ;
                    $comment .= $request->input('is_accepted') ? "I agree with Cancellation policy: Yes;\r\n" : "" ;

                    $dataOrder = [
                        'user_id' => $user->id,
                        'order_status_id' => $orderStatus->where('code', '=', 'on_hold')->first()->id,
                        'search_result_id' => $search_id,
                        'comment' => $comment,

                        'billing_address' => '',
                        'billing_country' => '',
                        'billing_city' => '',
                        'billing_postcode' => '',

                        'price' => $total_price,
                        'type' => $search_type,
                        'is_accepted' => (bool)$request->input('is_accepted'),
                        'book_status' => 1,
                        'operator_id' => $search->operatorData->id ?? 0,
                    ];

                    try {
                        $data_user = ['data_user' => ['user_email' => $user->email, 'first_name' => $user->first_name, 'last_name' => $user->last_name]];
                        $newOrder = $order->createOrder($dataOrder);
                        $response = $this->paymentSquareTrait($access_token, $total_price, $nonce, $newOrder->id);

                        if ($response->isSuccess()) {
                            $dataTransaction = [
                                'user_id' => $user->id,
                                'order_id' => $newOrder->id,
                                'is_success' => ($response->getResult()->getPayment()->getStatus() === 'COMPLETED') ? 1 : 0,
                                'transaction_id' => $response->getResult()->getPayment()->getId() ?? '',
                                'amount' => $response->getResult()->getPayment()->getTotalMoney()->getAmount() / 100 ?? 0,
                                'message' => $response->getBody()
                            ];
                        }
                        else {
                            $dataTransaction = [
                                'user_id' => $user->id,
                                'order_id' => $newOrder->id,
                                'amount' => $newOrder->price,
                                'message' => !empty($response) ? $response->getBody() : 'No Response!'
                            ];
                            $cart_errors = json_decode($response->getBody(), true)['errors'][0];
                        }
                        $newTransaction = $transaction->createTransaction($dataTransaction);

                        if ($newTransaction->is_success) {
                            $newOrder->order_status_id = $orderStatus->where('code', '=', 'paid')->first()->id;
                            $newOrder->payment_id = $response->getResult()->getPayment()->getId();
                            $newOrder->save();
                            if ($search_type === 'emptyLeg') {
                                EmptyLeg::find($search_id)->update(['active' => Config::get("constants.active.on-hold")]);
                            }
                            $regions = City::whereIn('geonameid', $operatorCity)->get()
                                ->unique(function ($item) {
                                    return $item['iso_country'].$item['iso_region'];
                                })
                                ->mapToGroups(function ($item, $key) {
                                    return [$item['iso_country'] => $item['iso_region']];
                                });

                            if (!empty($regions)) {
                                $operator_emails = ($search_type !== 'emptyLeg') ? OperatorCity::with(
                                    'operatorCity.regionCountry',
                                    'operator'
                                )
                                    ->whereHas('operatorCity.regionCountry', function ($query) use ($regions) {
                                        foreach ($regions as $country => $region) {
                                            $query->where('iso_country', $country)
                                                ->whereIn('iso_region', $region);
                                        }
                                    })
                                    ->whereHas('operator', function ($query) {
                                        $query->where('active', 1);
                                    })
                                    ->get()
                                    ->groupBy('email')->keys() : [$search->operator];

                                if (!empty($operator_emails)) {
                                    $operator_emails = ['operator_emails' => $operator_emails];

                                    $data_flight = [
                                        'data_flight' => [
                                            'start_city' => $search->departureCity->name,
                                            'start_state' => $search->departureCity->regionCountry->name,
                                            'start_airport' => $search->airportDeparture->name,
                                            'end_city' => $search->arrivalCity->name,
                                            'end_state' => $search->arrivalCity->regionCountry->name,
                                            'end_airport' => $search->airportArrival->name,
                                            'pax' => $search->pax ?? Config::get(
                                                    "constants.plane.type_plane.$search->type_plane.feature_plane.Passengers"
                                                ),
                                            'type' => $order->type,
                                            'date' => Carbon::parse(
                                                $search->departure_at ?? $search->date_departure
                                            )->format('F d Y'),
                                            'order_id' => $order->id
                                        ]
                                    ];

                                    $data_emails = array_merge($data_user, $operator_emails, $data_flight);

                                    dispatch(new SendEmailOperator((object)$data_emails));#->onQueue('emailOperator');

                                }

                                return redirect()->route(
                                    'client.orders.succeed',
                                    ['order_id' => $newOrder->id, $search_type]
                                );

                                return response()->json([
                                                            'order_id' => $newOrder->id,
                                                            'order' => Order::Find($newOrder->id),
                                                            'search' => Search::Find($newOrder->search_result_id),
                                                            'search_type' => $search_type,
                                                            'time' => $time,
                                                            'pricing' => $newOrder->price,
                                                        ]);
                            }

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

        $time_type = 'time_' . $search_type;

        return response()->json([
            'messages' => $messages,
            'upper_case_environment' => $upper_case_environment,
            'environment' => $environment,
            'applicationId' => $applicationId,
            'locationId' => $locationId,
            'search_id' => $search_id,
            'search_type' => $search_type,
            'pricing' => $total_price,
            'price' => $total_price,
            'time' => !empty($search->price->$time_type) ? $search->price->$time_type : '-',
            'user' => $user,
 #           'start_airport_name' => $start_airport_name,
 #           'end_airport_name' => $end_airport_name,
 #           'departure_at' => $departure_at,
            'pax' => !empty($search->pax) ? $search->pax : Config::get("constants.plane.type_plane.$search->type_plane.feature_plane.Passengers"),
#            'feeses' => $feeses,
            'total_price' => $total_price,
            'params' => $params,
            'request_method' => $request_method,
            'cart_errors' => $cart_errors,
            'pervis_confirm_url' => $pervis_confirm_url,
 #           'post_form_url' => $post_form_url,
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
                'pervis_confirm_url' => $pervis_search_url,
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
