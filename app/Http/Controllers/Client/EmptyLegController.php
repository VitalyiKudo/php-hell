<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use App\Models\EmptyLeg;

use Config;

use App\Http\Traits\CheckAgeUserTrait;

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
        $emptyLegs = $emptyLeg->getEmptyLegsFull()->where('active', '=', Config::get('constants.active.activated'));

        $typePlanes = Config::get('constants.plane.type_plane');

        $status = $this->CheckAge();

        return view('client.emptyLegs', compact('emptyLegs', 'typePlanes', 'status'));
    }
}
