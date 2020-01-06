<?php

namespace App\Http\Controllers\Client\Account\Profile;

use Auth;
use Hash;
use Carbon\Carbon;
use App\Models\Card;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Client\StoreCard as StoreCardRequest;
use App\Http\Requests\Client\UpdatePayment as UpdatePaymentRequest;

class PaymentController extends Controller
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

        return view('client.account.profile.payment', compact('user'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $card
     * @return \Illuminate\Http\Response
     */
    public function show($card)
    {
        $user = Auth::user();
        $card = $user->cards()->findOrFail($card);

        return view('client.account.profile.payment', compact('user', 'card'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Client\StoreCard  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCardRequest $request)
    {
        $user = $request->user();

        // Add card
        $paymentProfileId = $user->addCard(
            $request->input('number'),
            $request->input('expiration_year'),
            $request->input('expiration_month'),
            $request->input('cvv')
        );

        // Throw exception on error
        if (!$paymentProfileId) {
            throw ValidationException::withMessages([
                'number' => 'Can\'t add a card. Please try again later.',
            ]);
        }

        // Create a new card
        $card = new Card;

        $card->authorize_payment_id = $paymentProfileId;
        $card->last_four = substr($request->input('number'), -4);
        $card->expiration_month = $request->input('expiration_month');
        $card->expiration_year = $request->input('expiration_year');

        $user->cards()->save($card);

        return redirect()
            ->route('client.profile.payment.index')
            ->with('status', 'The card was successfully added.');
    }

    /**
     * Destroy the specified resource in storage.
     *
     * @param  int  $card
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $card)
    {
        $user = $request->user();
        $card = $user->cards()->findOrFail($card);

        // Delete card in Authorize
        if (! $user->deleteCard($card->authorize_payment_id)) {
            return redirect()
                ->route('client.profile.payment.index')
                ->with('status', 'Can\'t delete the card. Please try again later.')
                ->with('status-type', 'danger');
        }

        // Delete card from the storage
        $card->delete();

        return redirect()
            ->route('client.profile.payment.index')
            ->with('status', 'The card was successfully deleted.');
    }
}
