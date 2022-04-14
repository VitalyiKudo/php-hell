<?php

namespace App\Command\Order\CustomOrder\Create;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="CustomOrderCreate",
 *     required={"flightModel", "startPoint", "endPoint", "flightDate", "pax"}
 * )
 */

class CustomOrderCommand
{
    public $userId;

    /**
     * @OA\Property(type="string")
     */
    public $flightModel;

    /**
     * @OA\Property(type="string")
     */
    public $startPoint;

    /**
     * @OA\Property(type="string")
     */
    public $endPoint;

    /**
     * @OA\Property(type="string", example="04/12/2022")
     */
    public $flightDate;

    /**
     * @OA\Property(type="string")
     */
    public $aircraft;

    /**
     * @OA\Property(type="string")
     */
    public $aircraftOne;

    /**
     * @OA\Property(type="string")
     */
    public $aircraftTwo;

    /**
     * @OA\Property(type="string")
     */
    public $fromStopPoint;

    /**
     * @OA\Property(type="string")
     */
    public $toStopPoint;

    /**
     * @OA\Property(type="string", example="04/12/2022")
     */
    public $stopFlightDate;

    /**
     * @OA\Property(type="string")
     */
    public $fromReturnPoint;

    /**
     * @OA\Property(type="string")
     */
    public $toReturnPoint;

    /**
     * @OA\Property(type="string", example="04/12/2022")
     */
    public $returnFlightDate;

    /**
     * @OA\Property(type="integer")
     */
    public $pax;

    /**
     * @OA\Property(type="integer")
     */
    public $pets;

    /**
     * @OA\Property(type="integer")
     */
    public $bags;

    /**
     * @OA\Property(type="integer")
     */
    public $lbags;

    /**
     * @OA\Property(type="boolean")
     */
    public $wifi;

    /**
     * @OA\Property(type="boolean")
     */
    public $lavatory;

    /**
     * @OA\Property(type="boolean")
     */
    public $disabilities;

    /**
     * @OA\Property(type="boolean")
     */
    public $catering;

    /**
     * @OA\Property(type="string")
     */
    public $comment;
}
