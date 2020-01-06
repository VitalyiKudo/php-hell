<?php

namespace App\Http\Controllers\Client\Account\Profile;

use Auth;
use Hash;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\UpdatePayment as UpdatePaymentRequest;

class CompanionController extends Controller
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

        return view('client.account.profile.companion', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Client\UpdatePayment  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaymentRequest $request)
    {
        // $user = Auth::user();

        // //

        // $user->save();

        // return redirect()
        //     ->route('client.profile.payment.index')
        //     ->with('status', 'The account was successfully updated.');
    }

    /**
     * Destroy the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // $user = Auth::user();

        // Auth::guard()->logout();

        // $request->session()->invalidate();

        // $user->delete();

        // return redirect('/');
    }
}
