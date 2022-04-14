<?php

namespace App\Service\Order;

class OrderCommentBuilder
{
    /**
     * @psalm-param array{
     *   comment:string,
     *   aircraft:string,
     *   aircraft_one:string,
     *   aircraft_two:string,
     *   fromStopPoint:string,
     *   toStopPoint:string,
     *   stopFlightDate:string,
     *   fromReturnPoint:string,
     *   toReturnPoint:string,
     *   returnFlightDate:string,
     *   pets:int,
     *   bags:int,
     *   lbags:int,
     *   wifi:bool,
     *   lavatory:bool,
     *   disabilities:bool,
     *   catering:bool
     * }
     *
     * @return string
     */
    public function build(array $params): string
    {
        $comment = [];

        if ($params['comment']) {
            $comment[] = sprintf('Comment: %s;', $params['comment']);
        }

        if ($params['aircraft']) {
            $comment[] = sprintf('Preferred aircraft: %s;', $params['aircraft']);
        }

        if ($params['aircraftOne']) {
            $comment[] = sprintf('Preferred second aircraft: %s;', $params['aircraftOne']);
        }

        if ($params['aircraftTwo']) {
            $comment[] = sprintf('Preferred third aircraft: %s;', $params['aircraftTwo']);
        }

        if ($params['fromStopPoint']) {
            $comment[] = sprintf('From Stop Airport: %s;', $params['fromStopPoint']);
        }

        if ($params['toStopPoint']) {
            $comment[] = sprintf('To Stop Airport: %s;', $params['toStopPoint']);
        }

        if ($params['stopFlightDate']) {
            $comment[] = sprintf('Stop Date: %s;', $params['stopFlightDate']);
        }

        if ($params['fromReturnPoint']) {
            $comment[] = sprintf('From Return Airport: %s;', $params['fromReturnPoint']);
        }

        if ($params['toReturnPoint']) {
            $comment[] = sprintf('To Return Airport: %s;', $params['toReturnPoint']);
        }

        if ($params['returnFlightDate']) {
            $comment[] = sprintf('Return Date: %s;', $params['returnFlightDate']);
        }

        if ($params['pets']) {
            $comment[] = sprintf('Pets: %s;', $params['pets']);
        }

        if ($params['bags']) {
            $comment[] = sprintf('Bags: %s;', $params['bags']);
        }

        if ($params['lbags']) {
            $comment[] = sprintf('Large baggage: %s;', $params['lbags']);
        }

        if ($params['wifi']) {
            $comment[] = sprintf('Wi-Fi: %s;', 'Yes');
        }

        if ($params['lavatory']) {
            $comment[] = sprintf('Lavatory: %s;', 'Yes');
        }

        if ($params['disabilities']) {
            $comment[] = sprintf('People with disabilities: %s;', 'Yes');
        }

        if ($params['catering']) {
            $comment[] = sprintf('Catering: %s;', 'Yes');
        }

        return implode("\n", $comment);
    }
}
