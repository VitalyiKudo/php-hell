<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UsersChatsDataTable;
use App\Http\Requests\Chat\MessageSearch;
use App\Http\Requests\Chat\StoreMessageRequest;
use App\Http\Requests\Chat\PageRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\Chat\MessagesResource;
use App\Models\Room;
use App\Events\MessageSent;
use App\Models\User;
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
     * @throws \Exception
     */
    public function index(UsersChatsDataTable $dataTable)
    {
//        $rooms = $this->chatRoomService->getRoomsOrCreateNew('client', $request->page, $request->email);

//        return view('client.chats.chats_list', compact('rooms'));

        return $dataTable->render('admin.chats.list');
    }

    /**
     * @param \App\Models\Room $room
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getRoom(User $user)
    {
        $admin = Auth::user();
        $room  = $user->room;

        if (!$room) {
            $room = $this->chatRoomService->createRoomAdmin($user);
        }
        if ($admin->messages()->count() > 0) {
            if (Auth::guard('client')->check()) {
                $room->messages()->whereNotNull('administrator_id')->update(['saw' => true]);
            }
            else if (Auth::guard('admin')->check()) {
                $room->messages()->whereNotNull('user_id')->update(['saw' => true]);
            }

        }
        
        return view('admin.chats.view', compact('room', 'admin'));
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
