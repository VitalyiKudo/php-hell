<?php

namespace App\Http\Controllers\Api\Account\Profile;

use App\Http\Controllers\Controller;
use App\Models\FcmToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FireBaseController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/profile/account/set-fcm-token",
     *     description="User fcm token for firebase.",
     *     tags={"Account"},
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *               type="object",
     *               @OA\Property(
     *                   property="fcm_token",
     *                   description="User fcm_token of device",
     *                   type="string",
     *                   example="ereQe_e32dadopDIAJ29uAD0qie"
     *               ),
     *               @OA\Property(
     *                   property="email",
     *                   description="User email",
     *                   type="string",
     *                   example="example@mail.com"
     *               ),
     *               @OA\Property(
     *                   property="phone",
     *                   description="User phone",
     *                   type="string",
     *                   example="+4823948238489"
     *               ),
     *               @OA\Property(
     *                   property="device",
     *                   description="User device",
     *                   type="string",
     *                   example="Android 9.0"
     *               ),
     *           )
     *        )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @OA\Response(response=404, description="Not found"),
     *     @OA\Response(response=409, description="Already exist"),
     *     @OA\Response(response=422, description="Unprocessable entity")
     * )
     */
    public function storeToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fcm_token' => 'required|string|max:200',
            'phone' => 'string|nullable|max:25',
            'email' => 'email|nullable|max:150',
            'device' => 'required|string|max:150',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $query = User::where('email', '=', $request->input('email'));

        if (null != $request->input('phone')) {
            $query->orWhere('phone_number', '=', $request->input('phone'));
        }

        $user = $query->first();

        if ($user == null) {
            return response()->json('User not found', 404);
        }

        $deviceByToken = FcmToken::where('device', $request->input('device'))->first();

        if (null != $deviceByToken) {
            return response()->json('Token for that device already exist', 409);
        }

        $fcmToken = new FcmToken();
        $fcmToken->user_id = $user->id;
        $fcmToken->fcm_token = $request->input('fcm_token');
        $fcmToken->device = $request->input('device');

        $fcmToken->save();

        return response()->json($fcmToken);
    }
}
