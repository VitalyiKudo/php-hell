<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
#use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Admin\StoreAirportArea as StoreAirportAreaRequest;
use App\Http\Requests\Admin\UpdateAirportArea as UpdateAirportAreaRequest;

use Yajra\Datatables\Datatables;
use App\DataTables\AirportAreaDataTable;
use App\TableModels\AirportAreasTable;

use App\Models\AirportArea;

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
     * @param AirportArea $airportArea
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index1()
    {
        #dd($request);

        #$airportAreas = datatables($airportArea->getAirportAreas())->toJson();
        #$airportAreas = $airportArea->getAirportAreas();#->toJson();
        //$airportAreasJson = $airportAreas->toJson();
        #$airportAreasJson = datatables($airportAreas)->toJson();
        #$airportAreasJson = response()->json(datatables($airportAreas));
        #$airportAreasJson = datatables()->of($airportAreas)->toJson ();
#dd($airportAreas);
#dd($airportAreasJson);
        #return view('admin.airportAreas.list', compact('airportAreas'));
        #return view('admin.airportAreas.list', compact('airportAreas'/*, 'airportAreasJson'*/));
        return view('admin.airportAreas.list');
    }

    /**
     * @param AirportAreaDataTable $dataTableAll
     *
     * @return mixed
     */
    public function index(AirportAreaDataTable $dataTable, AirportArea $airportArea)
    {
        #dd($dataTable);

        #$airportAreas = datatables($airportArea->getAirportAreas())->toJson();
        #$airportAreas = $airportArea->getAirportAreas();#->toJson();
        //$airportAreasJson = $airportAreas->toJson();
        #$airportAreasJson = datatables($airportAreas)->toJson();
        #$airportAreasJson = response()->json(datatables($airportAreas));
        #$airportAreasJson = datatables()->of($airportAreas)->toJson ();
#dd($airportAreas);
#dd($airportAreasJson);
        #return view('admin.airportAreas.list', compact('airportAreas'));
        #return view('admin.airportAreas.list', compact('airportAreas'/*, 'airportAreasJson'*/));
        #return view('admin.airportAreas.list');
        try {
            /*
            $companies = Company::orderby('company_name', 'ASC')->get();
            $contacts = Contact::orderby('name', 'ASC')->get();
            $stautses = Status::orderby('status', 'ASC')->get();
            return $quoteDataTable->render('quotes.index', array(
                'companies' => $companies,
                'statuses' => $stautses,
                'contacts' => $contacts
            ));response()->json(*/
            #dd($airportAreas);
            return $dataTable->render('admin.airportAreas.list');
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    /**
     * Display a listing of the resource.
     *
     * @param AirportArea $airportArea
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index2(AirportArea $airportArea)
    {
        $datatable = \DataTable::model(\App\Models\AirportArea::class)
            ->tableModel(\App\TableModels\AirportAreasTable::class);

        #return view('users.index')->with(compact('datatable'));
        return view('admin.airportAreas.list')->with(compact('datatable'));
    }

    /**
     * @param Request     $request
     * @param AirportArea $airportArea
     *
     * @return void
     */
    public function ajaxDataList(Request $request, AirportArea $airportArea)
    {
        if ($request->ajax()) {
            #$data = Student::latest()->get();
            return Datatables::of($airportArea->getAirportAreas())
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" class="view btn btn-info btn-sm">View</a> <a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $typePlanes = Config::get('constants.TypePlane');

        return view('admin.airportAreas.create', compact('typePlanes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\StoreAirportArea $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAirportAreaRequest $request, AirportArea $airportArea)
    {
        $airportArea->create([
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
     * Store data from excel file.
     *
     * @param  StoreAirportArea $request
     * @return \Illuminate\Http\Response
     */

    public function import()
    {
        $status = "Excel file was not uploaded";
        if (request()->file('file') && request()->file('file')->extension() == 'xlsx') {
            AirportArea::whereNotNull('id')->delete();
            Excel::import(new AirportAreaImport, request()->file('file'));
            $status = "The database was successfully updated.";
        }

        return redirect()
            ->route('admin.airportAreas.index')
            ->with('status', $status);
    }

    /**
     * Display the specified resource.
     * @param AirportArea $airportArea
     * @param          $id
     * @return Response
     */
    public function show(AirportArea $airportArea, $id)
    {
        $airportArea = $airportArea->getAirportArea($id);

        return view('admin.airportAreas.view', compact('AirportArea'));
    }

    /**
     * Display the specified resource.
     * @param AirportArea $airportArea
     * @param          $id
     * @return Response
     */
    public function edit(AirportArea $airportArea, $id)
    {
        $airportArea = $airportArea->getAirportArea($id);

        $typePlanes = Config::get('constants.TypePlane');

        return view('admin.airportAreas.edit', compact('AirportArea', 'typePlanes'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAirportArea $request
     * @param AirportArea $airportArea
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateAirportAreaRequest $request, AirportArea $airportArea, $id)
    {
        $airportArea->updateOrCreate(
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
            ->route('admin.airportAreas.index', $id)
            ->with('status', 'The AirportArea was successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AirportArea  $airportArea
     * @return \Illuminate\Http\Response
     */
    public function destroy(AirportArea $airportArea)
    {
        $airportArea->delete();

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
