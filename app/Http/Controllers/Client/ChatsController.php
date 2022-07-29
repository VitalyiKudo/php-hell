<?php

namespace App\Http\Controllers\Client;

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

    /**
     * @param \App\Http\Requests\Chat\RoomSearch $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(RoomSearch $request)
    {
        $rooms = $this->chatRoomService->getRoomsOrCreateNew('client', $request->page, $request->email);

        return view('client.chats.chats_list', compact('rooms'));
    }

    /**
     * @param int $room_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getRoom(Room $room)
    {
        $user = Auth::user();

        if ($room && !$user->rooms()->where('rooms.id', $room->id)->exists()) {
            abort(404);
        }

        if ($user->messages()->count() > 0) {
            if (Auth::guard('client')->check()) {
                $room->messages()->whereNotNull('administrator_id')->update(['saw' => true]);
            }
            else if (Auth::guard('admin')->check()) {
                $room->messages()->whereNotNull('user_id')->update(['saw' => true]);
            }

        }

        return view('client.chats.chats_messages', compact('room', 'user'));
    }

    /**
     * @param int $room_id
     * @param \App\Http\Requests\Chat\PageRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function fetchMessages(Room $room, PageRequest $request): AnonymousResourceCollection
    {
        $message = Message::with('user', 'administrator')
            ->where('room_id', $room->id)
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
        $message = (new ChatCreateMessage(Auth::user(), $request->message, $request->room_id))->handle();

        broadcast(new MessageSent($message->load(['user', 'administrator']), $request->room_id))->toOthers();

        return JsonResource::make(['status' => 'success']);
    }
}
