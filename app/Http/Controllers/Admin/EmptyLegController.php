<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

use App\Imports\EmptyLegImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEmptyLeg as StoreEmptyLegRequest;
use App\Http\Requests\Admin\UpdateEmptyLeg as UpdateEmptyLegRequest;

use App\Models\EmptyLeg;
use App\DataTables\EmptyLegDataTable;

use App\Http\Traits\SearchCityTrait;
use App\Http\Traits\SearchAirportTrait;
use App\Http\Traits\SearchOperatorTrait;

class EmptyLegController extends Controller
{
    use SearchCityTrait, SearchAirportTrait, SearchOperatorTrait;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        set_time_limit(8000000);
        ini_set('max_execution_time', 8000000);
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     * @param EmptyLegDataTable $dataTable
     * @return mixed|string
     */
    public function index(EmptyLegDataTable $dataTable)
    {
        try {
            return $dataTable->render('admin.emptyLegs.list');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $typePlanes = Config::get('constants.plane.type_plane');

        return view('admin.emptyLegs.create', compact('typePlanes'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  \App\Http\Requests\Admin\StoreEmptyLeg $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmptyLegRequest $request, EmptyLeg $emptyLeg)
    {
        $emptyLeg->create([
            'icao_departure' => $request->input('icaoDeparture'),
            'geoNameIdCity_departure' => $request->input('geoNameIdCityDeparture'),
            'icao_arrival' => $request->input('icaoArrival'),
            'geoNameIdCity_arrival' => $request->input('geoNameIdCityArrival'),
            'operator' => $request->input('operatorEmail'),
            'type_plane' => $request->input('typePlane'),
            'price' => $request->input('price'),
            'date_departure' => $request->input('dateDeparture')
                          ]);

        return redirect()
            ->route('admin.emptyLegs.index')
            ->with('status', 'The EmptyLeg was successfully created.');
    }

    /**
     * Store data from excel file.
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import()
    {
        $status = "Excel file was not uploaded";
        if (request()->file('file') && request()->file('file')->extension() == 'xlsx') {
            EmptyLeg::whereNotNull('id')->delete();
            Excel::import(new EmptyLegImport, request()->file('file'));
            $status = "The database was successfully updated.";
        }

        return redirect()
            ->route('admin.emptyLegs.index')
            ->with('status', $status);
    }

    /**
     * Display the specified resource.
     * @param EmptyLeg $emptyleg
     * @param          $id
     * @return Response
    */
    public function show(EmptyLeg $emptyleg, $id)
    {
        $emptyLeg = $emptyleg->getEmptyLegs()->where('id', $id)->at(0);

        return view('admin.emptyLegs.view', compact('emptyLeg'));
    }

    /**
     * Display the specified resource.
     * @param EmptyLeg $emptyleg
     * @param          $id
     * @return Response
     */
    public function edit(EmptyLeg $emptyleg, $id)
    {
        $emptyLeg = $emptyleg->getEmptyLegs()->where('id', $id)->at(0);

        $typePlanes = Config::get('constants.plane.type_plane');

        return view('admin.emptyLegs.edit', compact('emptyLeg', 'typePlanes'));
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateEmptyLeg $request
     * @param EmptyLeg $emptyleg
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateEmptyLegRequest $request, EmptyLeg $emptyleg, $id)
    {
        $emptyleg->where('id', '=', $id)
            ->update(['icao_departure' => $request->icaoDeparture,
                     'geoNameIdCity_departure' => $request->geoNameIdCityDeparture,
                     'icao_arrival' => $request->icaoArrival,
                     'geoNameIdCity_arrival' => $request->geoNameIdCityArrival,
                     'operator' => $request->operatorEmail,
                     'type_plane' => $request->typePlane,
                     'price' => $request->price,
                     'date_departure' => $request->dateDeparture,
                     'active' => $request->active
                 ]);

        return redirect()
            ->route('admin.emptyLegs.index')
            ->with('status', 'The EmptyLeg was successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     * @param EmptyLeg $emptyLeg
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(EmptyLeg $emptyLeg)
    {
        $emptyLeg->delete();

        return redirect()
            ->route('admin.emptyLegs.index')
            ->with('status', 'The EmptyLeg was successfully deleted.');
    }

    /**
     * @param Request $request
     * @return false|\Illuminate\Http\JsonResponse
     */
    public function ajaxSearchAirport(Request $request)
    {
        $airports = $this->SearchAirportNameLike($request->airport)
                    ->whereNotIn('geoNameIdCity', [0])
                    ->sortBy('name')
                    ->sortBy('cities.name')
                    ->sortBy('regionCountry.name')
                    ->sortBy('country.name');

        if (empty($airports)) {
            return false;
        }
        else {
            $res = collect([]);
            foreach ($airports as $value) {
                $res = $res->push([
                    'icao' => $value->icao,
                    'iata' => (!empty($value->iata) && $value->iata !== 'noV') ? $value->iata : null,
                    'airport' => !empty($value->name) ? $value->name : null,
                    'geoNameIdCity' => !empty($value->geoNameIdCity) ? $value->geoNameIdCity : null,
                    'city' => !empty($value->cities->name) ? $value->cities->name : null,
                    'region' => !empty($value->regionCountry->name) ? $value->regionCountry->name : null,
                    'country' => !empty($value->country->name) ? $value->country->name : null
              ]);
            }
        }

        return response()->json($res);
    }

    /**
     * @param Request $request
     * @return false|\Illuminate\Http\JsonResponse
     */
    public function ajaxSearchOperator(Request $request)
    {
          $operators = $this->SearchOperatorNameLike($request->operatorEmail)
            ->sortBy('email')
            ->sortBy('name');

        if (empty($operators)) {
            return false;
        }
        else {
            $data = $operators->map(function ($res) {
                return ['email' => $res->email, 'name' => $res->name];
            });
        }

        return response()->json($data);
    }
}
