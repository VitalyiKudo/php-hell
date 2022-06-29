<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EmptyLeg;

#use AWS\CRT\HTTP\Request;
use Config;
use Carbon;

use App\Traits\CheckAgeUserTrait;

class EmptyLegController extends Controller
{
    use CheckAgeUserTrait;

    /**
     * Show the EmptyLeg page
     * @param EmptyLeg $emptyLeg
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(EmptyLeg $emptyLeg)
    {
        $emptyLegs = $emptyLeg->getEmptyLegsFull()->where('active', '=', Config::get('constants.active.Active'))->paginate(3);

        $typePlanes = Config::get('constants.plane.type_plane');

        $status = $this->CheckAge();

        return response()->json(compact('emptyLegs', 'typePlanes', 'status'));
    }

    public function ajaxSearch (Request $request)
    {
        $startPointName = $request->startPointName;
        $endPointName = $request->endPointName;
        $flightDate = (!empty($request->flightDate)) ? Carbon::parse($request->flightDate)->format('Y-m-d') : null;

        $filterEmptyLegs = collect();
        if (!empty($startPointName) || !empty($endPointName) || !empty($flightDate)) {
            $filterEmptyLegs = EmptyLeg::with(
                'departureCity',
                'departureCity.regionCountry',
                'departureCity.country',
                'airportDeparture',
                'airportDeparture.airportAreas',
                'airportDeparture.airportAreas.airport',

                'arrivalCity',
                'arrivalCity.regionCountry',
                'arrivalCity.country',
                'airportArrival',
                'airportArrival.airportAreas',
                'airportArrival.airportAreas.airport',
            )
                ->where(function ($query) use ($startPointName) {
                    if (!empty($startPointName)) {
                        $query->whereHas('departureCity', function ($query) use ($startPointName) {
                            $query->where('name', 'like', "%{$startPointName}%");
                        })
                            ->orWhereHas('airportDeparture', function ($query) use ($startPointName) {
                                $query->where('name', 'like', "%{$startPointName}%")
                                    ->orWhere('iata', 'like', "{$startPointName}%")
                                    ->orWhere('icao', 'like', "{$startPointName}%");
                            })
                            ->orWhereHas(
                                'airportDeparture.airportAreas.airport',
                                function ($query) use ($startPointName) {
                                    $query->where('name', 'like', "%{$startPointName}%")
                                        ->orWhere('iata', 'like', "{$startPointName}%")
                                        ->orWhere('icao', 'like', "{$startPointName}%");
                                }
                            )
                            ->orWhereHas('departureCity.regionCountry', function ($query) use ($startPointName) {
                                $query->where('name', 'like', "%{$startPointName}%");
                            });
                    }
                })
                ->where(function ($query) use ($endPointName) {
                    if (!empty($endPointName)) {
                        $query->whereHas('arrivalCity', function ($query) use ($endPointName) {
                            $query->where('name', 'like', "%{$endPointName}%");
                        })
                            ->orWhereHas('airportArrival', function ($query) use ($endPointName) {
                                $query->where('name', 'like', "%{$endPointName}%")
                                    ->orWhere('iata', 'like', "{$endPointName}%")
                                    ->orWhere('icao', 'like', "{$endPointName}%");
                            })
                            ->orWhereHas('airportArrival.airportAreas.airport', function ($query) use ($endPointName) {
                                $query->where('name', 'like', "%{$endPointName}%")
                                    ->orWhere('iata', 'like', "{$endPointName}%")
                                    ->orWhere('icao', 'like', "{$endPointName}%");
                            })
                            ->orWhereHas('arrivalCity.regionCountry', function ($query) use ($endPointName) {
                                $query->where('name', 'like', "%{$endPointName}%");
                            });
                    }
                })
                ->where(function ($query) use ($flightDate) {
                    if (!empty($flightDate)) {
                        $query->where('date_departure', '=', $flightDate);
                    }
                })
                ->where('active', Config::get('constants.active.Active'))
                ->get()
            ->paginate(10);
        }

        return response()->json(compact('filterEmptyLegs'));
    }
}
