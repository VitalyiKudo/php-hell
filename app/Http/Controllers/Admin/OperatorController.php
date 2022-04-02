<?php

namespace App\Http\Controllers\Admin;

use App\Models\Operator;
use App\Models\OperatorCity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Imports\OperatorImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOperator as StoreOperatorRequest;
use App\Http\Requests\Admin\UpdateOperator as UpdateOperatorRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
# use DB;
use Validator;
use App\Http\Traits\SearchCityTrait;
use App\Http\Traits\SearchAirportTrait;

class OperatorController extends Controller
{
    use SearchCityTrait, SearchAirportTrait;

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
        $operators = Operator::paginate(25);

        return view('admin.operators.list', compact('operators'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.operators.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\StoreOperator $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOperatorRequest $request, Operator $operator)
    {
        #dd($request);
        $operator->name = trim($request->input('name'));
        $operator->web_site = trim($request->input('web_site'));
        $operator->email = trim($request->input('email'));
        $operator->email_other = trim($request->input('email_other'));
        $operator->phone = trim($request->input('phone'));
        $operator->mobile = trim($request->input('mobile'));
        $operator->fax = trim($request->input('fax'));
        $operator->address = trim($request->input('address'));
        $operator->active = $request->input('active');

        $operator->save();

        foreach ($request->input('city') as $city) {
            OperatorCity::updateOrCreate(
                ['email' => $request->input('email'), 'geoNameIdCity' => $city]
            );

        }

        return redirect()
            ->route('admin.operators.index')
            ->with('status', 'The operator was successfully created.');
    }

    /**
     * Store data from excel file.
     *
     * @param  \App\Http\Requests\Admin\StoreOperator $request
     * @return \Illuminate\Http\Response
     */

    public function import()
    {
        $status = "Excel file was not uploaded";
        if (request()->file('file') && request()->file('file')->extension() == 'xlsx') {
            Operator::whereNotNull('id')->delete();
            Excel::import(new OperatorImport, request()->file('file'));
            $status = "The database was successfully updated.";
        }

        return redirect()
            ->route('admin.operators.index')
            ->with('status', $status);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Operator  $operator
     * @return \Illuminate\Http\Response
     */
    public function show(Operator $operator)
    {
        return view('admin.operators.view', compact('operator'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Operator  $operator
     * @return \Illuminate\Http\Response
     */
    public function edit(Operator $operator)
    {
        #dd($operator);
        $city = OperatorCity::with('operatorCity', 'operatorCity.regionCountry', 'operatorCity.country')
            ->where('email', '=', $operator->email)
            ->where('active', '=', Config::get('constants.active.activated'))
            ->get()
            ->sortBy('operatorCity.name')
            ->sortBy('operatorCity.regionCountry.name')
            ->sortBy('operatorCity.country.name');

        $cities = collect();
        foreach ($city as $value) {
            $cities->push([
                  'geonameid' => $value->operatorCity->geonameid,
                  'city' => $value->operatorCity->name ?? null,
                  'region' => $value->operatorCity->regionCountry->name ?? null,
                  'country' => $value->operatorCity->country->name ?? null
              ]);
        }

        return view('admin.operators.edit', compact('operator', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\UpdateOperator  $request
     * @param  \App\Models\Operator  $operator
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOperatorRequest $request, Operator $operator)
    {
        $operator->name = trim($request->input('name'));
        $operator->web_site = trim($request->input('web_site'));
        #$operator->email = trim($request->input('email'));
        $operator->email_other = trim($request->input('email_other'));
        $operator->phone = trim($request->input('phone'));
        $operator->mobile = trim($request->input('mobile'));
        $operator->fax = trim($request->input('fax'));
        $operator->address = trim($request->input('address'));
        $operator->active = $request->input('active');

        $operator->save();

        $city_old = collect(json_decode($request->input('city_old')))->map(function ($value) {
            return $value->geonameid;
        });
        $city = collect($request->input('city'))->transform(function ($value) {
            return (int)$value;
        });
        $city_del = $city_old->diff($city)->flip()->all();#->implode(', ');
        $city_full = $city_old->merge($city)->unique()->flip()->map(function ($value, $key) use ($city_del) {
            return (array_key_exists($key, $city_del)) ? Config::get('constants.active.not-activated') : Config::get('constants.active.activated');
        });

        foreach ($city_full as $key => $value) {
            OperatorCity::updateOrCreate(
                ['email' => $request->input('email_actual'), 'geoNameIdCity' => $key],
                ['active' => $value]
            );
        }

        return redirect()
            ->route('admin.operators.index', $operator->id)
            ->with('status', 'The operator was successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Operator  $operator
     * @return \Illuminate\Http\Response
     */
    public function destroy(Operator $operator)
    {
        $operator->delete();

        return redirect()
            ->route('admin.operators.index')
            ->with('status', 'The operator was successfully deleted.');
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->get('query');
            $query = str_replace(" ", "%", $query);
            $operators = DB::table('operators')
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
            return view('admin.operators.pagination', compact('operators'))->render();
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
            'email' => 'required|email|unique:operators,email',
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

    public function ajaxSearchAirport(Request $request)
    {
        $airports = $this->SearchAirportNameLike($request->airports)
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
                  'city' => !empty($value->cities->name) ? $value->cities->name : null,
                  'region' => !empty($value->regionCountry->name) ? $value->regionCountry->name : null,
                  'country' => !empty($value->country->name) ? $value->country->name : null
              ]);
            }
        }

        return response()->json($res);
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
