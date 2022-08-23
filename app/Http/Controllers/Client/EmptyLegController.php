<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\AirportArea;
use Illuminate\Http\Request;

use App\Models\EmptyLeg;

use Config;
use Carbon;

use App\Traits\CheckAgeUserTrait;

class EmptyLegController extends Controller
{
    use CheckAgeUserTrait;

    /**
     * @param EmptyLeg    $emptyLeg
     * @param Request     $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(EmptyLeg $emptyLeg, Request $request)
    {
        $startCity = trim($request->startPoint) ?? null;
        $startAirport = trim($request->startAirport) ?? null;
        $startAirportArea = (!empty($request->startArea) && trim($request->startArea) === 'Area') ?
            AirportArea::where('geoNameIdCity', $startCity)
            ->get()
            ->map(fn($value) => ['icao' =>  $value->icao])
            ->keyBy('icao')
            ->keys()
            :
            null;

        $endCity = trim($request->endPoint) ?? null;
        $endAirport = trim($request->endAirport) ?? null;
        $endAirportArea = (!empty($request->endArea) && trim($request->endArea) === 'Area') ?
            AirportArea::where('geoNameIdCity', $endCity)
                ->get()
                ->map(fn($value) => ['icao' =>  $value->icao])
                ->keyBy('icao')
                ->keys()
            :
            null;
        $flightDate = (!empty($request->flightDate)) ? Carbon::parse($request->flightDate)->format('Y-m-d') : null;

        $emptyLegsData = $emptyLeg->getEmptyLegsFront($startCity, $startAirportArea, $endCity, $endAirportArea, $flightDate);
        $emptyLegs = $emptyLegsData->paginate(10);
        $countEmptyLegs = $emptyLegsData->count();

        $typePlanes = Config::get('constants.plane.type_plane');

        $status = $this->CheckAge();

        /** @var TYPE_NAME $request */
        if (request()->ajax()) {
            $emptyLegs = (count($emptyLegs) > 0) ? $emptyLegs : [];

            return view('client.emptyLegs-load', compact('emptyLegs', 'typePlanes', 'status', 'countEmptyLegs'));#->nest('child', 'client.emptyLegs', compact('emptyLegs', 'typePlanes', 'status', 'countEmptyLegs'));
        }
        return view('client.emptyLegs', compact('emptyLegs', 'typePlanes', 'status', 'countEmptyLegs'));
    }
}
