<?php

namespace App\Http\Controllers\Api\Account\Profile;

use App\UserCompanion;
use App\User;
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
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        return response()->json([
            'user' => $user
        ]);
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

        return response()->json([
            'companion' => $companion
        ]);
    }

    public function list() {
        $userId = Auth::user()->id;
        
        $user = User::find($userId);    
        
        $companions = UserCompanion::where('user_id', $userId)->get();
        
        return response()->json([
            'companion' => $companions,
            'user' => $user,
        ]);

    }

    public function edit($id) {

        $companion = UserCompanion::findOrFail($id);

        return response()->json([
            'companion' => $companion,
        ]);

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

        return response()->json([
            'status' => 'The company was successfully destroyed.',
        ]);
    }
}
