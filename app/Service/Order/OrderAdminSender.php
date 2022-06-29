<?php

namespace App\Service\Order;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class OrderAdminSender
{
    public function send(
        User $user,
        int $resultId,
        string $date,
        string $startCity,
        string $endCity,
        string $comment,
        int $pax,
        string $flightModel
    ) {
        $date = Carbon::parse($date)->format('d F Y');
        Mail::send([], [], static function ($message) use ($user, $resultId, $date, $startCity, $endCity, $comment, $pax, $flightModel) {
            $message->from($user->email, 'JetOnset team');
            $message->to('request@jetonset.com')->subject("We have request for you #{$resultId}");

            $flightModel = ucfirst($flightModel);
            $message->setBody(
            <<<MESSAGE
Dear all!

Can you send me the quote for a flight from {$startCity} to {$endCity} on {$date} for a company of {$pax} people for {$flightModel} class of airplane. \r\n

Request details:
{$comment}

Best regards,
{$user->first_name} {$user->last_name}
JetOnset
{$user->phone_number}
MESSAGE
            );
        });
    }
}
