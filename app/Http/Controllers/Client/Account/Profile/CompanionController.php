<?php

namespace App\Http\Controllers\Client\Account\Profile;

use App\Models\UserCompanion;
use App\Models\User;
use Auth;
use Hash;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\UpdatePayment as UpdatePaymentRequest;
use App\Http\Requests\Client\StoreCompanionRequest ;

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
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Client\StoreCard  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompanionRequest $request)
    {

        $loggedinUser = Auth::user()->id;

        $companion = new UserCompanion;
        $companion->user_id = $loggedinUser;
        $companion->first_name = $request->companion_first_name;
        $companion->last_name = $request->companion_last_name;
        $companion->email = $request->companion_email;
        $companion->dob = Carbon::parse($request->companion_date_of_birth)->format('Y-m-d');
        $companion->address = $request->companion_home_address;
        $companion->street_no = $request->companion_street_name_and_number;
        $companion->city = $request->companion_city;
        $companion->state = $request->companion_state;
        $companion->country = $request->companion_country;
        $companion->zipcode = $request->companion_zip_code;
        $companion->save();

        return redirect()
            ->route('client.profile.companions.index')
            ->with('status', 'The record was successfully added.');
    }

    public function list() {
        $userId = Auth::user()->id;

        $user = User::find($userId);

        $companions = UserCompanion::where('user_id', $userId)->get();
        return view('client.account.profile.companion-list', compact('companions','user'));

    }

    public function edit($id) {

        $companion = UserCompanion::findOrFail($id);

        return view('client.account.profile.companion-edit', compact('companion'));

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
    public function destroy($id)
    {
        $user = Auth::user();

        $companion = UserCompanion::where('id',$id)->first();

        $companion->delete();

        return redirect()->back();
    }
}
