<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Traits\SearchCityAirportsTrait;

class AirportController extends Controller
{
    use SearchCityAirportsTrait;

    /**
     * Get the airports list.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *     path="/api/airports",
     *     description="Airports List Page",
     *     tags={"Airport"},
     *     @OA\Parameter(
     *         description="Name of Airport",
     *         in="query",
     *         name="query",
     *         required=false,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     *
     */
    public function getAirportsList(Request $request)
    {
        $keyword = $request->input('query');

        if (mb_strlen($keyword) >= 3) {
            return response()->json($this->SearchCityAirportNameLike($keyword)
                ->map(fn($value) => [
                    'id' =>  $value['geonameid'],
                    'city' => $value['city'],
                    'region' => $value['region'],
                    'country' => $value['country'],
                    'area' => $value['area'],
                    'airport' => $value['airportFull']
                    ]
                )
            );
        }
        else {
            return response()->json('empty data!');
        }
    }
}
