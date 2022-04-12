<?php

namespace App\Http\Controllers\Api\Account\Profile;

use Auth;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Validator;
use App\Models\User;
use Carbon\Carbon;

class AccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api,api_admin')->except(['login', 'register', 'admin_login']);
    }

    /**
     * Display current User data.
     *
     * @return \Illuminate\Http\Response
     *
     * @OA\Get(
     *     path="/api/profile/account",
     *     description="User data Page",
     *     tags={"Account"},
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
     * @param  \App\Http\Requests\Client\UpdateAccount  $request
     * @return \Illuminate\Http\Response
     *
     * @OA\Put(
     *     path="/api/profile/account",
     *     description="Update user data",
     *     tags={"Account"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *               type="object",
     *               @OA\Property(
     *                   property="email",
     *                   description="User email",
     *                   type="string",
     *                   example="ihamzehald@gmail.com"
     *               ),
     *               @OA\Property(
     *                   property="password",
     *                   description="User password",
     *                   type="string",
     *                   example="larapoints123"
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
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //$user = Auth::user();

        if ($request->input('email')) {
            $user->email = $request->input('email');
        }

        if ($request->input('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        $user->updateAuthorizeCustomer();

        return response()->json([
            'status' => 'The account was successfully updated.',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Client\UpdateAccount  $request
     * @return \Illuminate\Http\Response
     *
     * @OA\Put(
     *     path="/api/profile/account/login",
     *     description="User login",
     *     tags={"Account"},
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *               type="object",
     *               @OA\Property(
     *                   property="email",
     *                   description="User email",
     *                   type="string",
     *                   example="ihamzehald@gmail.com"
     *               ),
     *               @OA\Property(
     *                   property="password",
     *                   description="User password",
     *                   type="string",
     *                   example="larapoints123"
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
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (! $user = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken(auth()->user());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Client\UpdateAccount  $request
     * @return \Illuminate\Http\Response
     *
     * @OA\Put(
     *     path="/api/profile/account/admin_login",
     *     description="Administrator login",
     *     tags={"Account"},
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *               type="object",
     *               @OA\Property(
     *                   property="email",
     *                   description="Administrator email",
     *                   type="string",
     *                   example="ihamzehald@gmail.com"
     *               ),
     *               @OA\Property(
     *                   property="password",
     *                   description="Administrator password",
     *                   type="string",
     *                   example="larapoints123"
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
    public function admin_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (! $user = auth()->guard('admin')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken(auth()->guard('admin')->user());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     *
     * @OA\Post(
     *     path="/api/profile/account/register",
     *     description="User register",
     *     tags={"Account"},
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
     *                   property="password",
     *                   description="User password",
     *                   type="string",
     *                   example="larapoints123"
     *               ),
     *               @OA\Property(
     *                   property="password_confirmation",
     *                   description="User password confirmation",
     *                   type="string",
     *                   example="larapoints123"
     *               ),
     *
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
     *                   property="gender",
     *                   type="string",
     *                   enum={"male", "female", "other"}
     *               ),
     *               @OA\Property(
     *                   property="address",
     *                   description="Address",
     *                   type="string",
     *                   example="larapoints123"
     *               ),
     *               @OA\Property(
     *                   property="address_secondary",
     *                   type="string",
     *                   example="larapoints 123"
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
     *
     *               @OA\Property(
     *                   property="privacy",
     *                   description="Privacy",
     *                   type="boolean",
     *                   example="true"
     *               ),
     *               @OA\Property(
     *                   property="terms",
     *                   description="Terms",
     *                   type="boolean",
     *                   example="true"
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
    protected function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'phone_number' => 'sometimes|nullable|string',
            'date_of_birth' => 'sometimes|nullable|date_format:m/d/Y',
            'gender' => 'sometimes|nullable|string|in:male,female,other',

            'address' => 'sometimes|nullable|string',
            'address_secondary' => 'sometimes|nullable|string',
            'country' => 'sometimes|nullable|string',
            'city' => 'sometimes|nullable|string',
            'state' => 'sometimes|nullable|string',
            'postcode' => 'sometimes|nullable|string',

            'billing_address' => 'sometimes|nullable|string',
            'billing_country' => 'sometimes|nullable|string',
            'billing_city' => 'sometimes|nullable|string',
            'billing_state' => 'sometimes|nullable|string',
            'billing_postcode' => 'sometimes|nullable|string',

            'privacy' => 'accepted',
            'terms' => 'accepted',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'gender' => $request->input('gender'),

            'phone_number' => $request->input('phone_number'),
            'address' => $request->input('address'),
            'address_secondary' => $request->input('address_secondary'),
            'country' => $request->input('country'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'postcode' => $request->input('postcode'),

            'billing_address' => $request->input('billing_address'),
            'billing_country' => $request->input('billing_country'),
            'billing_city' => $request->input('billing_city'),
            'billing_state' => $request->input('billing_state'),
            'billing_postcode' => $request->input('billing_postcode'),

            'api_token' => Str::random(60),
        ];

        if ($request->has('date_of_birth')) {
            $data['date_of_birth'] = $request->filled('date_of_birth') ? Carbon::createFromFormat('m/d/Y', $request->input('date_of_birth')) : null;
        }

        $user = User::create($data);

        $token = Str::random(60);
        $user->forceFill([
            'api_token' => hash('sha256', $token),
        ])->save();

        return response()->json(['user' => $user, 'token' => $token]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Client\UpdateAccount  $request
     * @return \Illuminate\Http\Response
     *
     * @OA\Put(
     *     path="/api/profile/account/refresh",
     *     description="User refresh",
     *     tags={"Account"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     *
     */
    public function refresh(Request $request)
    {
        $user = auth('api')->user();
        return $this->createNewToken($user);
    }


    /**
     * Destroy the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * @OA\Delete(
     *     path="/api/profile/account",
     *     description="User destroy",
     *     tags={"Account"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     *
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();

        $user->delete();

        return response()->json([
            'status' => 'The account was successfully destroyed.',
        ]);
    }

    private function createNewToken($user)
    {
        $token = Str::random(60);

        $user->forceFill([
            'api_token' => hash('sha256', $token),
        ])->save();

        return response()->json([
            'token' => $token,
        ]);

    }
}
