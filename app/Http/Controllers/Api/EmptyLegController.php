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

        return response()->json(compact('emptyLegs', 'typePlanes', 'status'));
    }
}
