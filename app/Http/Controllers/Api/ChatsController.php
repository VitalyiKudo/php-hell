<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Chat\PageRequest;
use App\Http\Requests\Chat\StoreMessageRequest;
use App\Http\Resources\Chat\MessagesResource;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Events\MessageSent;
use App\Models\Room;
use App\Service\Chat\ChatCreateMessage;
use App\Service\Chat\ChatRoom;
use Illuminate\Http\JsonResponse;
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
     * Get the rooms list.
     *
     * @param \Illuminate\Http\Request $request
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

    public function index()
    {
        $rooms      = $this->chatRoomService->getRoomsOrCreateNew('api');
        $rooms_list = [];

        foreach ($rooms as $room) {

            if (auth()->guard('api_admin')->check()) {
                $rooms_list[] = [
                    'link'  => url('chat/' . $room->id),
                    'title' => $room->user->first_name . " " . $room->user->last_name . " " . $room->user->email . " (" . $room->messages->whereNotInStrict('user_id', null)->where('saw', false)->count() . ")",
                ];
            }
            elseif (auth()->guard('api')->check()) {
                $rooms_list[] = [
                    'link'  => url('chat/' . $room->id),
                    'title' => $room->user->first_name . " " . $room->user->last_name . " " . $room->user->email . " (" . $room->messages->whereNotInStrict('administrator_id', null)->where('saw', false)->count() . ")",
                ];
            }

        }

        return response()->json($rooms_list);
    }

    /**
     * Get room info.
     *
     * @param \Illuminate\Http\Request $request
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

    /**
     * @param \App\Models\Room $room
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRoom(Room $room): JsonResponse
    {
        $user = auth()->user();

        if (!$user->rooms()->where('id', $room->id)->exists()) {
            abort(404);
        }

        if ($user->messages()->count() > 0) {
            if (Auth::guard('api')->check()) {
                $room->messages()->whereNotNull('administrator_id')->update(['saw' => true]);
            }
            else if (Auth::guard('api_admin')->check()) {
                $room->messages()->whereNotNull('user_id')->update(['saw' => true]);
            }
        }

        return response()->json([
                                    'room_id'      => $room->id,
                                    'user'         => $user,
                                    'chat_id'      => 'chat.' . $room->id,
                                    'get_messages' => '/api/messages/' . $room->id,
                                    'add_message'  => '/api/messages',
                                ]);
    }

    /**
     * Get the list of messages.
     *
     * @param \Illuminate\Http\Request $request
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

    /**
     * @param int $room_id
     * @param \App\Http\Requests\Chat\PageRequest $request
     * @return \App\Models\Message[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function fetchMessages(Room $room, PageRequest $request)
    {
        $message = Message::with('user', 'administrator')
            ->where('room_id', $room->id)
            ->latest()
            ->simplePaginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = $request->page);

        return MessagesResource::collection($message);
    }

    /**
     * Add message
     *
     * @param array $data
     * @return \App\Models\User
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
