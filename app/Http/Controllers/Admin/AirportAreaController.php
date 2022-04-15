<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
#use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Admin\StoreAirportArea as StoreAirportAreaRequest;
use App\Http\Requests\Admin\UpdateAirportArea as UpdateAirportAreaRequest;

use App\DataTables\AirportAreaDataTable;

use App\Models\AirportArea;
use App\Models\Airport;

use App\Http\Traits\SearchCityTrait;
use App\Http\Traits\SearchAirportTrait;
use App\Http\Traits\SearchOperatorTrait;

class AirportAreaController extends Controller
{
    use SearchCityTrait, SearchAirportTrait, SearchOperatorTrait;

    /**
     * Create a new controller instance.
     *
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
     *
     * @param AirportAreaDataTable $dataTable
     *
     * @return mixed|string
     */
    public function index(AirportAreaDataTable $dataTable)
    {
        try {
            return $dataTable->render('admin.airportAreas.list');
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(AirportArea $getArea)
    {
        return view('admin.airportAreas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\StoreAirportArea $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAirportAreaRequest $request, AirportArea $getArea)
    {
        $getArea->create([
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
            ->route('admin.airportAreas.index')
            ->with('status', 'The AirportArea was successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param AirportArea $getArea
     * @param          $geoNameIdCity
     *
     * @return Response
     */
    public function show(AirportArea $getArea, $geoNameIdCity)
    {
        $airportArea = $getArea->getAirportAreas()->where('geoNameIdCity', $geoNameIdCity)->at(0);

        return view('admin.airportAreas.view', compact('airportArea'));
    }

    /**
     * Display the specified resource.
     *
     * @param AirportArea $getArea
     * @param          $geoNameIdCity
     *
     * @return Response
     */
    public function edit(AirportArea $getArea, $geoNameIdCity)
    {
        $airportArea = $getArea->getAirportAreas()->where('geoNameIdCity', $geoNameIdCity)->at(0);
        $realAirportArea = $airportArea['areaAirport']->implode('icao', ',');

        return view('admin.airportAreas.edit', compact('airportArea', 'realAirportArea'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAirportArea $request
     * @param AirportArea $airportArea
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateAirportAreaRequest $request, AirportArea $getArea)
    {
        $delAirport = collect(explode(',', $request->realAirportArea))->diff($request->areaAirport)->values();
        $addAirport = collect($request->areaAirport)->diff(explode(',', $request->realAirportArea))->values();

        $getArea->whereIn('icao', $delAirport)->where('geoNameIdCity', $request->geoNameIdCity)->delete();

        if ($addAirport->isNotEmpty()) {
            foreach ($addAirport as $value) {
                $getArea->firstOrCreate(['icao' => $value, 'geoNameIdCity' => $request->geoNameIdCity]);
            }
        }

        return redirect()
            ->route('admin.airportAreas.index')
            ->with('status', 'The AirportArea was successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AirportArea  $airportArea
     * @return \Illuminate\Http\Response
     */
    public function destroy(AirportArea $getArea)
    {
        $getArea->delete();

        return redirect()
            ->route('admin.airportAreas.index')
            ->with('status', 'The AirportArea was successfully deleted.');
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->get('query');
            $query = str_replace(" ", "%", $query);
            $airportAreas = DB::table('empty_legs')
                ->whereNull('deleted_at')
                ->where('name', 'like', '%'.$query.'%')
                ->orWhere('web_site', 'like', '%'.$query.'%')
                ->orWhere('email', 'like', '%'.$query.'%')
                ->orWhere('phone', 'like', '%'.$query.'%')
                ->orWhere('mobile', 'like', '%'.$query.'%')
                ->orWhere('fax', 'like', '%'.$query.'%')
                ->orWhere('address', 'like', '%'.$query.'%')
                ->orderBy('id', 'asc')
                ->paginate(25);
            return view('admin.airportAreas.pagination', compact('airportAreas'))->render();
        }
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxValidationEmail(Request $request)
    {
        $input = $request->only(['email']);

        $request_data = [
            'email' => 'required|email|unique:empty_legs,email',
        ];

        $validator = Validator::make($input, $request_data);

        // json is null
        if ($validator->fails()) {
            $errors = json_decode(json_encode($validator->errors()), 1);
            return response()->json([
                                        'success' => false,
                                        'message' => array_reduce($errors, 'array_merge', array()),
                                    ]);
        } else {
            return response()->json([
                                        'success' => true,
                                        'message' => 'The email is available'
                                    ]);
        }
        return false;
    }

    /**
     * @param Request     $request
     * @param AirportArea $getArea
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxSearchCity(Request $request, AirportArea $getArea)
    {
        #dd($getArea->getAirportAreas()->pluck('geoNameIdCity'));
        $city = $this->SearchCityNameLike($request->city)
            ->whereNotIn('geonameid', [0])
            ->whereNotIn('geonameid', $getArea->getAirportAreas()->pluck('geoNameIdCity'))
            ->sortBy('name')
            ->sortBy('regionCountry.name')
            ->sortBy('country.name')
            ->map(fn($value) => [
                'geonameid' => $value->geonameid,
                'city' => $value->name ?? null,
                'region' => $value->regionCountry->name ?? null,
                'country' => $value->country->name ?? null
            ]);

        return response()->json($city);
    }

    /**
     * @param Request $request
     *
     * @return false|\Illuminate\Http\JsonResponse
     */
    public function ajaxSearchAirport(Request $request)
    {
        #dd($request);
        $airports = $this->SearchAirportNameLike($request->airport)
            ->whereNotIn('geoNameIdCity', [0, (int)$request->geoNameIdCity])
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
     *
     * @return false|\Illuminate\Http\JsonResponse
     */
    public function ajaxSearchCityAirports(Request $request, AirportArea $getAirport)
    {
        #dd($getAirport->getAirportAreas()->where('geoNameIdCity', 4164223)->toArray());
        #$airport = $getAirport->getAirportAreas()->where('geoNameIdCity', $request->geoNameIdCity);
        $airport = Airport::where('geoNameIdCity', $request->geoNameIdCity)
            ->get()
            ->map(function ($value) {
                return [
                    'icao' => $value->icao,
                    'iata' => (!empty($value->iata) && $value->iata !== 'noV') ? $value->iata : null,
                    'airport' => $value->name ?? null,
                    'geoNameIdCity' => $value->geoNameIdCity ?? null,
                    'city' => $value->cities->name ?? null,
                    'region' => $value->regionCountry->name ?? null,
                    'country' => $value->country->name ?? null,
                ];
            });
        #->toJson();

        #dd($airport);
        return response()->json($airport);
        #return $airport;
    }

    public function ajaxValidationStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pswd' => 'required',
            'email' => 'required|email',
            'address' => 'required',
        ]);

        if ($validator->passes()) {
            return response()->json(['success'=>'Added new records.']);
        }

        return response()->json(['error'=>$validator->errors()]);
    }
}
