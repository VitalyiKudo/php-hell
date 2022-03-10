<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Administrator;
use App\Models\Room;
use App\Events\MessageSent;

class ChatsController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api,api_admin')->except(['login']);;
    }

    /**
     * Get the rooms list.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     * @OA\Get(
     *     path="/api/chats",
     *     description="List of Chats",
     *     tags={"Chats"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200, 
     *         description="OK",
     *     )
     * )
     * 
     */
    
    public function index(){
        if(auth()->guard('api')->check()){
            if(auth()->user()->rooms()->count() < 1){
                $room = auth()->user()->rooms()->create([
                    'name' => auth()->guard('api')->user()->email
                ]);
                
                $admins = Administrator::all();
                $room->administrators()->attach($admins);
            }
            $rooms = Room::where('user_id', auth()->user()->id)->get();
        } else {
            $rooms = Room::all();
        }

        $rooms_list = [];
        
        foreach ($rooms as $room){

            if(auth()->guard('api_admin')->check()){
                $rooms_list[] = [
                    'link' => url('chat/' . $room->id),
                    'title' => $room->user->first_name . " " . $room->user->last_name . " " . $room->user->email . " (" . $room->messages()->whereNotNull('administrator_id')->where('saw', false)->count() . ")",
                ];
            }elseif(auth()->guard('api')->check()){
                $rooms_list[] = [
                    'link' => url('chat/' . $room->id),
                    'title' => $room->user->first_name . " " . $room->user->last_name . " " . $room->user->email . " (" . $room->messages()->whereNotNull('user_id')->where('saw', false)->count() . ")",
                ];
            }

        }

        return response()->json($rooms_list);
    }
    
    /**
     * Get room info.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     * @OA\Get(
     *     path="/api/chat/{room_id}",
     *     description="Get room",
     *     tags={"Chats"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="room_id",
     *         description="",
     *         in = "path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         ) 
     *     ),
     *     @OA\Response(
     *         response=200, 
     *         description="OK",
     *     )
     * )
     * 
     */
    
    public function getRoom($room_id){
        $user = auth()->user();
        
        if($user->messages()->count() > 0){
            $user->messages()->where('room_id', $room_id)->update(['saw' => true]);
        }

        return response()->json([
            'room_id' => $room_id,
            'user' => $user,
            'chat_id' => 'chat.'.$room_id,
            'get_messages' => '/api/messages/'.$room_id,
            'add_message' => '/api/messages',
        ]);
    }
    
    /**
     * Get the list of messages.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     * @OA\Get(
     *     path="/api/messages/{room_id}",
     *     description="list of messages",
     *     tags={"Chats"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="room_id",
     *         description="",
     *         in = "path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         ) 
     *     ),
     *     @OA\Response(
     *         response=200, 
     *         description="OK",
     *     )
     * )
     * 
     */
    
    public function fetchMessages($room_id){
        return Message::with('user', 'administrator')->where('room_id', $room_id)->get();
    }
    
    /**
     * Add message
     *
     * @param  array  $data
     * @return \App\User
     * 
     * @OA\Post(
     *     path="/api/messages",
     *     description="Add message",
     *     tags={"Chats"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *               type="object",
     *               @OA\Property(
     *                   property="room_id",
     *                   description="Room ID",
     *                   type="integer",
     *                   example="4"
     *               ),
     *               @OA\Property(
     *                   property="message",
     *                   description="Message",
     *                   type="string",
     *                   example="Some message"
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
    
    public function sendMessages(Request $request){
        $message = auth()->user()->messages()->create([
            'room_id' => $request->room_id,
            'message' => $request->message,
        ]);

        broadcast(new MessageSent($message->load(['user', 'administrator']), $request->room_id))->toOthers();
        
        return response()->json(['status' => 'success']);
    }

}
