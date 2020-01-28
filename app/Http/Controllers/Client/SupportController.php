<?php

namespace App\Http\Controllers\Client;

use Helpdeskeddy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Models\SubscribedUser;

class SupportController extends Controller
{
    /**
     * Show the support page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('client.support');
    }

    /**
     * Create a new ticket for the client form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function client(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2',
            'email' => 'required|email',
            'phone_number' => 'sometimes|nullable|string',
            'company' => 'sometimes|nullable|string',
            'message' => 'required|string|min:8',
        ]);
        

        $status = Helpdeskeddy::createTicket([
            'title' => 'Support request from website',
            'description' => $request->input('message'),
            'department_id' => 1,
            'user_email' => $request->input('email'),
            // 'custom_fields[1]' => $request->input('phone_number'),
            // 'custom_fields[2]' => $request->input('company'),
        ]);

        return redirect()
            ->route('client.support')
            ->with('status', 'The ticket was successfully created.');
    }

    /**
     * Create a new ticket for the operator form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function operator(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2',
            'email' => 'required|email',
            'phone_number' => 'sometimes|nullable|string',
            'company' => 'sometimes|nullable|string',
            'message' => 'required|string|min:8',
        ]);
        

        $status = Helpdeskeddy::createTicket([
            'title' => 'Operator request from website',
            'description' => $request->input  ('message'),
            'department_id' => 2,
            'user_email' => $request->input('email'),
        ]);

        return redirect()
            ->route('client.support')
            ->with('status', 'The ticket was successfully created.');
    }

    public function subscribe(Request $request) {


        $this->validate($request, [
            'email' => 'required|email|unique:subscribed_users',
        ]);


        // Check if email already exists
        $email = $request->input('email');


        $subscribedUser = new SubscribedUser;
        $subscribedUser->email = $email;
        $subscribedUser->status = 1;
        $subscribedUser->save();

        return (["message"=>["success"=>"you have successfully subscribed for the newsletter"]]);
    }
}
