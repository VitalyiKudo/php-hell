<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests\Chat\MessageSearch;
use App\Http\Requests\Chat\RoomSearch;
use App\Http\Requests\Chat\StoreMessageRequest;
use App\Http\Requests\Chat\PageRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\Chat\MessagesResource;
use App\Models\Message;
use App\Models\Administrator;
use App\Models\Room;
use App\Events\MessageSent;
use App\Service\Chat\ChatCreateMessage;
use App\Service\Chat\ChatRoom;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{
    /**
     * @var \App\Service\Chat\ChatRoom
     */
    protected ChatRoom $chatRoomService;

    /**
     * @param \App\Service\Chat\ChatRoom $chatRoom
     */
    public function __construct(ChatRoom $chatRoom)
    {
        $this->chatRoomService = $chatRoom;
    }

//    /**
//     * @param \App\Http\Requests\Chat\RoomSearch $request
//     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
//     * @throws \Exception
//     */
//    public function index(RoomSearch $request)
//    {
//        $rooms = $this->chatRoomService->getRoomsOrCreateNew('client', $request->page, $request->email);
//
//        return view('client.chats.chats_list', compact('rooms'));
//    }

    /**
     * @param \App\Models\Room $room
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getRoom()
    {
        $user = Auth::user();
        $room = $user->room;

        if (!$room) {
            $room = $this->chatRoomService->createRoom($user);
        }

        if ($user->messages()->count() > 0) {
            $room->messages()->whereNotNull('administrator_id')->update(['saw' => true]);
        }

        return view('client.chats.chats_messages', compact('room', 'user'));
    }

    /**
     * @param \App\Models\Room $room
     * @param \App\Http\Requests\Chat\PageRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function fetchMessages(Room $room, PageRequest $request): AnonymousResourceCollection
    {
        $messages = $this->chatRoomService->searchMessage($room, $request->page);

        return MessagesResource::collection($messages);
    }

    /**
     * @param \App\Models\Room $room
     * @param \App\Http\Requests\Chat\MessageSearch $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function searchMessages(Room $room, MessageSearch $request)
    {
        $messages = $this->chatRoomService->searchMessage($room, $request->page, $request->text);
        return MessagesResource::collection($messages);
    }

    /**
     * @param \App\Http\Requests\Chat\StoreMessageRequest $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function sendMessages(StoreMessageRequest $request): JsonResource
    {
        $message = (new ChatCreateMessage(Auth::user(), $request->message, $request->room_id))->handle();

        broadcast(new MessageSent($message->load(['user', 'administrator']), $request->room_id))->toOthers();

        return JsonResource::make(['status' => 'success']);
    }
}
