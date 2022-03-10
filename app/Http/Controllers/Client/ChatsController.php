<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Administrator;
use App\Models\Room;
use App\Events\MessageSent;

class ChatsController extends Controller
{
    public function __construct(){
        $this->middleware('auth:client,admin');
    }
    
    public function index(){
        if(auth()->guard('client')->check()){
            if(auth()->user()->rooms()->count() < 1){
                $room = auth()->user()->rooms()->create([
                    'name' => auth()->guard('client')->user()->email
                ]);
                
                $admins = Administrator::all();
                $room->administrators()->attach($admins);
            }
            $rooms = Room::where('user_id', auth()->user()->id)->get();
        } else {
            $rooms = Room::all();
        }

        return view('client.chats.chats_list', compact('rooms'));
    }
    
    public function getRoom($room_id){
        $user = auth()->user();
        
        if($user->messages()->count() > 0){
            $user->messages()->where('room_id', $room_id)->update(['saw' => true]);
        }

        return view('client.chats.chats_messages', compact('room_id', 'user'));
    }
    
    public function fetchMessages($room_id){
        return Message::with('user', 'administrator')->where('room_id', $room_id)->get();
    }
    
    public function sendMessages(Request $request){
        $message = auth()->user()->messages()->create([
            'room_id' => $request->room_id,
            'message' => $request->message,
        ]);

        broadcast(new MessageSent($message->load(['user', 'administrator']), $request->room_id))->toOthers();
        
        return ['status' => 'success'];
    }
}
