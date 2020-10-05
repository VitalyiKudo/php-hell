<?php

namespace App\Http\Controllers\Client\Account\Profile;

use Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\UpdatePersonalInfromation as UpdatePersonalInfromationRequest;

class PersonalInformationController extends Controller
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
        /*
        print_r(Auth::user()->id);
        
        if (Auth::check())
        {
            echo 'ok';
        } else {
            echo 'no';
        }
        */
        
        $user = Auth::user();

        return view('client.account.profile.personal-information', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Client\UpdatePersonalInfromation  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePersonalInfromationRequest $request)
    {
        $user = Auth::user();

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->phone_number = $request->input('phone_number');

        if ($request->has('date_of_birth')) {
            $user->date_of_birth = $request->filled('date_of_birth') ? Carbon::createFromFormat('m/d/Y', $request->input('date_of_birth')) : null;
        }

        $user->address = $request->input('address');
        $user->country = $request->input('country');
        $user->city = $request->input('city');
        $user->state = $request->input('state');
        $user->postcode = $request->input('postcode');

        $user->billing_address = $request->input('billing_address');
        $user->billing_country = $request->input('billing_country');
        $user->billing_city = $request->input('billing_city');
        $user->billing_state = $request->input('billing_state');
        $user->billing_postcode = $request->input('billing_postcode');

        $user->save();

        $user->updateAuthorizeCustomer();

        return redirect()
            ->route('client.profile')
            ->with('status', 'The settings was successfully updated.');
    }
}
