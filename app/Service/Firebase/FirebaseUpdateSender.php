<?php

namespace App\Service\Firebase;

use App\Models\FcmToken;
use App\Models\FirebaseClient;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class FirebaseUpdateSender
{
    private FirebaseClient $firebaseClient;

    /**
     * FirebaseOrderUpdateSender constructor.
     * @param FirebaseClient $firebaseClient
     */
    public function __construct(FirebaseClient $firebaseClient)
    {
        $this->firebaseClient = $firebaseClient;
    }

    public function send(int $userId, Notification $notification)
    {
        $user = User::where('id', $userId)->firstOrFail();

        /** @var Collection FcmToken[] $relatedTokens */
        $relatedTokens = $user->fcmTokens;

        if (!$relatedTokens->isEmpty()) {

            $tokens = [];

            foreach ($relatedTokens as $relatedToken) {
                $tokens[] = $relatedToken->fcm_token;
            }

            $response = $this->firebaseClient
                ->withTitle($notification->title)
                ->withBody($notification->message)
                ->withAdditionalData(['channelId' => $notification->channel])
                ->sendNotification($tokens);

            Log::info($response);
        }
    }
}
