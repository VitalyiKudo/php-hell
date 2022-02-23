<?php

namespace App\Http\Controllers\Api\Account\Profile;

use Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\UpdatePersonalInfromation as UpdatePersonalInfromationRequest;
use Illuminate\Http\Request;
use Validator;

class PersonalInformationController extends Controller
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
     *     path="/api/profile",
     *     description="User data Page",
     *     tags={"Personal Information"},
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
        $user = Auth::user();

        return response()->json([
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Client\UpdatePersonalInfromation  $request
     * @return \Illuminate\Http\Response
     * 
     * @OA\Put(
     *     path="/api/profile",
     *     description="Update profile data",
     *     tags={"Personal Information"},
     *     security={{"bearerAuth":{}}},
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
     *                   property="email",
     *                   description="User email",
     *                   type="string",
     *                   example="ihamzehald@gmail.com"
     *               ),
     *               @OA\Property(
     *                   property="phone_number",
     *                   description="Phone Number",
     *                   type="string",
     *                   example="+44444444444"
     *               ),
     *               @OA\Property(
     *                   property="date_of_birth",
     *                   description="Date of birth",
     *                   type="string",
     *                   example="11/12/1986"
     *               ),
     *               @OA\Property(
     *                   property="address",
     *                   description="Address",
     *                   type="string",
     *                   example="larapoints123"
     *               ),
     *               @OA\Property(
     *                   property="country",
     *                   description="Country",
     *                   type="string",
     *                   example="USA"
     *               ),
     *               @OA\Property(
     *                   property="city",
     *                   description="City",
     *                   type="string",
     *                   example="New York"
     *               ),
     *               @OA\Property(
     *                   property="state",
     *                   description="State",
     *                   type="string",
     *                   example="California"
     *               ),
     *               @OA\Property(
     *                   property="postcode",
     *                   description="Postcode",
     *                   type="string",
     *                   example="333333333"
     *               ),
     *               @OA\Property(
     *                   property="billing_address",
     *                   description="Billing Address",
     *                   type="string",
     *                   example="Address"
     *               ),
     *               @OA\Property(
     *                   property="billing_country",
     *                   description="Billing Country",
     *                   type="string",
     *                   example="Country"
     *               ),
     *               @OA\Property(
     *                   property="billing_city",
     *                   description="Billing City",
     *                   type="string",
     *                   example="City"
     *               ),
     *               @OA\Property(
     *                   property="billing_state",
     *                   description="Billing State",
     *                   type="string",
     *                   example="State"
     *               ),
     *               @OA\Property(
     *                   property="billing_postcode",
     *                   description="Billing Postcode",
     *                   type="string",
     *                   example="Postcode"
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
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'phone_number' => 'sometimes|nullable|string',
            'date_of_birth' => 'sometimes|nullable|date_format:m/d/Y',

            'address' => 'sometimes|nullable|string',
            'country' => 'sometimes|nullable|string',
            'city' => 'sometimes|nullable|string',
            'state' => 'sometimes|nullable|string',
            'postcode' => 'sometimes|nullable|string',

            'billing_address' => 'sometimes|nullable|string',
            'billing_country' => 'sometimes|nullable|string',
            'billing_city' => 'sometimes|nullable|string',
            'billing_state' => 'sometimes|nullable|string',
            'billing_postcode' => 'sometimes|nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

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
        
        return response()->json([
            'user' => $user
        ]);
    }
}
