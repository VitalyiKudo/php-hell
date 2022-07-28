<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests\Chat\StoreMessageRequest;
use App\Http\Requests\Chat\PageRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\Chat\MessagesResource;
use App\Models\Message;
use App\Models\Administrator;
use App\Models\Room;
use App\Events\MessageSent;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:client,admin');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (Auth::guard('client')->check()) {
            if (Auth::user()->rooms()->count() < 1) {
                $room = Auth::user()->rooms()->create(
                    [
                        'name' => Auth::guard('client')->user()->email
                    ]
                );

                $admins = Administrator::all();
                $room->administrators()->attach($admins);
            }
            $rooms = Room::where('user_id', auth()->user()->id)->get();
        }
        else {
            $rooms = Room::all();
        }

        return view('client.chats.chats_list', compact('rooms'));
    }

    /**
     * @param int $room_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getRoom(int $room_id)
    {
        $user = auth()->user();

        if ($user->messages()->count() > 0) {
            $user->messages()->where('room_id', $room_id)->update(['saw' => true]);
        }

        return view('client.chats.chats_messages', compact('room_id', 'user'));
    }

    /**
     * @param int $room_id

     */
    public function fetchMessages(int $room_id, PageRequest $request)
    {
        $message = Message::with('user', 'administrator')
            ->where('room_id', $room_id)
            ->latest()
            ->simplePaginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = $request->page);

        return MessagesResource::collection($message);
    }

    /**
     * @param \App\Http\Requests\Chat\StoreMessageRequest $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function sendMessages(StoreMessageRequest $request): JsonResource
    {
        $user = Auth::user();

        $message = $user->messages()->create(
            [
                'room_id' => $request->room_id,
                'message' => $request->message,
            ]
        );

        broadcast(new MessageSent($message->load(['user', 'administrator']), $request->room_id))->toOthers();

        return JsonResource::make(['status' => 'success']);
    }
}
