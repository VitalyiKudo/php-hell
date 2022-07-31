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

use App\Traits\SearchCityTrait;
use App\Traits\SearchAirportTrait;
use App\Traits\SearchOperatorTrait;
use App\Traits\EmptyLegStatusTrait;
use App\Traits\SearchCityAirportsTrait;

class EmptyLegController extends Controller
{
    use SearchCityTrait, SearchAirportTrait, SearchOperatorTrait, EmptyLegStatusTrait, SearchCityAirportsTrait;

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
        $emptyLeg = $emptyleg->getEmptyLegsFull()->where('id', $id)->at(0);

        $status = ['status' => Config::get('constants.active'), 'statusBg' => Config::get('constants.active_bg')];

        return view('admin.emptyLegs.view', compact('emptyLeg', 'status'));
    }

    /**
     * Display the specified resource.
     * @param EmptyLeg $emptyleg
     * @param          $id
     * @return Response
     */
    public function edit(EmptyLeg $emptyleg, $id)
    {
        $emptyLeg = $emptyleg->getEmptyLegsFull()->where('id', $id)->at(0);

        $typePlanes = Config::get('constants.plane.type_plane');

        $status = ['status' => Config::get('constants.active'), 'statusBg' => Config::get('constants.active_bg')];

        return view('admin.emptyLegs.edit', compact('emptyLeg', 'typePlanes', 'status'));
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
        $airports = $this->SearchCityAirportNameLike($request->airport);

        if (empty($airports)) {
            return false;
        }
        else {
            $res = collect([]);
            foreach ($airports as $value) {
                foreach ($value['airportFull'] as $airport) {
                    $res = $res->push([
                      'icao' => $airport['icao'],
                      'iata' => $airport['iata'],
                      'airport' => $airport['name'],
                      'geoNameIdCity' => $value['geonameid'],
                      'city' => $value['city'],
                      'region' => $value['region'],
                      'country' => $value['country']
                  ]);
                }
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
