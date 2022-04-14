<?php

namespace App\Command\Order\CustomOrder\Create;

use App\Fetcher\CityFetcher;
use App\Fetcher\ClientFetcher;
use App\Fetcher\SearchFetcher;
use App\Models\Order;
use App\Service\Order\OrderAdminSender;
use App\Service\Order\OrderClientSender;
use App\Service\Order\OrderCommentBuilder;
use DomainException;

class CustomOrderHandler
{
    private $commentBuilder;
    private $searchFetcher;
    private $clientFetcher;
    private $adminSender;
    private $clientSender;

    public function __construct(
        ClientFetcher $clientFetcher,
        OrderCommentBuilder $commentBuilder,
        SearchFetcher $searchFetcher,
        OrderAdminSender $adminSender,
        OrderClientSender $clientSender
    ) {
        $this->clientFetcher = $clientFetcher;
        $this->commentBuilder = $commentBuilder;
        $this->searchFetcher = $searchFetcher;
        $this->adminSender = $adminSender;
        $this->clientSender = $clientSender;
    }

    public function handle(CustomOrderCommand $command)
    {
        $user = $this->clientFetcher->findUserById($command->userId);

        if (!$user) {
            throw new DomainException('User not exists.');
        }

        $searchResult = $this->searchFetcher->getSearchLastByUserId($command->userId);

        $comment = $this->commentBuilder->build([
            'comment' => $command->comment,
            'aircraft' => $command->aircraft,
            'aircraftOne' => $command->aircraftOne,
            'aircraftTwo' => $command->aircraftTwo,
            'fromStopPoint' => $command->fromStopPoint,
            'toStopPoint' => $command->toStopPoint,
            'stopFlightDate' => $command->stopFlightDate,
            'fromReturnPoint' => $command->fromReturnPoint,
            'toReturnPoint' => $command->toReturnPoint,
            'returnFlightDate' => $command->returnFlightDate,
            'pets' => $command->pets,
            'bags' => $command->bags,
            'lbags' => $command->lbags,
            'wifi' => $command->wifi,
            'lavatory' => $command->lavatory,
            'disabilities' => $command->disabilities,
            'catering' => $command->catering,
        ]);

        Order::new(
            $command->userId,
            5, //todo
            $searchResult->id,
            $comment,
            $command->flightModel,
            0 //todo
        );

        $this->adminSender->send(
            $user,
            $searchResult->result_id,
            $command->flightDate,
            $command->startPoint,
            $command->endPoint,
            $comment,
            $command->pax,
            $command->flightModel
        );

        $this->clientSender->send($user, $searchResult->id);
    }
}
