<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EmptyLeg;

use Config;

use App\Traits\CheckAgeUserTrait;

class EmptyLegController extends Controller
{
    use CheckAgeUserTrait;

    /**
     * Show the EmptyLeg page
     * @param EmptyLeg $emptyLeg
     * @param Request  $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(EmptyLeg $emptyLeg, Request $request)
    {
        $emptyLegs = $emptyLeg->getEmptyLegs($request)->paginate(10);

        $typePlanes = Config::get('constants.plane.type_plane');

        $status = $this->CheckAge();

        /** @var TYPE_NAME $request */
        if (request()->ajax()) {
            $emptyLegs = (count($emptyLegs) > 0) ? $emptyLegs : [];
            return view('client.emptyLegs-load', compact('emptyLegs', 'typePlanes', 'status'));
        }
        return view('client.emptyLegs', compact('emptyLegs', 'typePlanes', 'status'));
    }
}
