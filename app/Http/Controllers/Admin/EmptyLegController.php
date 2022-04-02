<?php

namespace App\Http\Controllers\Admin;

use App\Models\EmptyLeg;
use App\Models\OperatorCity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Imports\EmptyLegImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEmptyLeg as StoreEmptyLegRequest;
use App\Http\Requests\Admin\UpdateEmptyLeg as UpdateEmptyLegRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
#use Illuminate\Support\Collection;
# use DB;
use Validator;
use App\Http\Traits\SearchCityTrait;
use App\Http\Traits\SearchAirportTrait;
use App\Http\Traits\SearchOperatorTrait;

class EmptyLegController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emptyLegs = EmptyLeg::with('operatorData', 'airportDeparture', 'airportArrival')->get();
        $emptyLegs = $emptyLegs->map(function ($res) {
            return [
                'id' => $res->id,
                'icaoDeparture' => $res->icao_departure,
                'airportDeparture' => $res->airportDeparture->name,
                'icaoArrival' => $res->icao_arrival,
                'airportArrival' => $res->airportArrival->name,
                'operatorEmail' => $res->operator,
                'operatorName' => $res->operatorData->name,
                'typePlane' => $res->type_plane,
                'price' => $res->price,
                'dateDeparture' => $res->date_departure,
                'active' => $res->active
            ];
        })->paginate(25);

        return view('admin.emptyLegs.list', compact('emptyLegs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $typePlanes = Config::get('constants.TypePlane');

        return view('admin.emptyLegs.create', compact('typePlanes'));
    }

    /**
     * Store a newly created resource in storage.
     *
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
            'operator' => $request->input('operator'),
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
     *
     * @param  StoreEmptyLeg $request
     * @return \Illuminate\Http\Response
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
        $emptyLeg = $emptyleg->getEmptyLeg($id);

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
        $emptyLeg = $emptyleg->getEmptyLeg($id);

        $typePlanes = Config::get('constants.TypePlane');

        return view('admin.emptyLegs.edit', compact('emptyLeg', 'typePlanes'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param UpdateEmptyLeg $request
     * @param EmptyLeg $emptyleg
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateEmptyLegRequest $request, EmptyLeg $emptyleg, $id)
    {
            $emptyleg->updateOrCreate(
                ['id' => $id],
                ['icao_departure' => $request->icaoDeparture,
                  'geoNameIdCity_departure' => $request->geoNameIdCityDeparture,
                  'icao_arrival' => $request->icaoArrival,
                  'geoNameIdCity_arrival' => $request->geoNameIdCityArrival,
                  'operator' => $request->operatorEmail,
                  'type_plane' => $request->typePlane,
                  'price' => $request->price,
                  'date_departure' => $request->dateDeparture,
                  'active' => $request->active
                ]
            );

        return redirect()
            ->route('admin.emptyLegs.index', $id)
            ->with('status', 'The EmptyLeg was successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmptyLeg  $emptyLeg
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmptyLeg $emptyLeg)
    {
        $emptyLeg->delete();

        return redirect()
            ->route('admin.emptyLegs.index')
            ->with('status', 'The EmptyLeg was successfully deleted.');
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->get('query');
            $query = str_replace(" ", "%", $query);
            $emptyLegs = DB::table('empty_legs')
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
            return view('admin.emptyLegs.pagination', compact('emptyLegs'))->render();
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
     * @param Request $request
     *
     * @return false|\Illuminate\Http\JsonResponse
     */
    public function ajaxSearchCity(Request $request)
    {
        $city = $this->SearchCityNameLike($request->city)
                    ->whereNotIn('geonameid', [0])
                    ->sortBy('name')
                    ->sortBy('regionCountry.name')
                    ->sortBy('country.name');

        if (empty($city)) {
            return false;
        }
        else {
            $res = collect([]);
            foreach ($city as $value) {
                $res = $res->push([
                    'geonameid' => $value->geonameid,
                  'city' => !empty($value->name) ? $value->name : null,
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
     *
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
