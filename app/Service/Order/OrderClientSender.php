<?php

namespace App\Service\Order;

use App\Models\User;
use Illuminate\Support\Facades\Mail;

class OrderClientSender
{
    public function send(
        User $user,
        int $searchId
    ) {
        Mail::send([], [], function ($message) use ($user, $searchId) {
            $message->from('hitman@humanit.pro', 'JetOnset team');
            $message->to($user->email)->subject("Your request for quote on JetOnset # {$searchId}");
            $message->setBody("Dear {$user->first_name} {$user->last_name}\n\nWe have received your request and will send you the quote in the shortest possible time.\nFor details and status of your request please use the link:\nhttps://jetonset.com/requests\n\nBest regards,\nJetOnset team.");
        });
    }
}
