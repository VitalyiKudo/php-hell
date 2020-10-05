<?php

namespace App\Http\Controllers\Client\Account\Profile;

use Auth;
use Hash;
use App\Models\Search;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\UpdateAccount as UpdateAccountRequest;

class QuoteController extends Controller
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
        $searches = Search::where('user_id', $user->id)->get();

        return view('client.account.profile.quote', compact('user', 'searches'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Client\UpdateAccount  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAccountRequest $request)
    {
        $user = Auth::user();

        if ($request->input('email')) {
            $user->email = $request->input('email');
        }

        if ($request->input('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        $user->updateAuthorizeCustomer();

        return redirect()
            ->route('client.profile.account.index')
            ->with('status', 'The account was successfully updated.');
    }

    /**
     * Destroy the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();

        Auth::guard()->logout();

        $request->session()->invalidate();

        $user->delete();

        return redirect('/');
    }
}
