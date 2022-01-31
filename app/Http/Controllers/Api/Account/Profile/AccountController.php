<?php

namespace App\Http\Controllers\Api\Account\Profile;

use Auth;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Validator;
use App\User;

class AccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except(['login', 'register']);
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
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        $user = Auth::user();

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
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
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
            'privacy' => 'accepted',
            'terms' => 'accepted',
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'api_token' => Str::random(60),
        ]);
        
        return response()->json($user);
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
