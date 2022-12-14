<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AirportsDataTable;
use App\Models\Airport;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAirport as StoreAirportRequest;
use App\Http\Requests\Admin\UpdateAirport as UpdateAirportRequest;
use Carbon\Carbon;
use DB;

class AirportController extends Controller
{
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
    public function index(AirportsDataTable $dataTable)
    {
        return $dataTable->render('admin.airports.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        return view('admin.airports.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\StoreAirport  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAirportRequest $request)
    {
        $airport = new Airport;

        $airport->name = $request->input('name');
        $airport->city = $request->input('city');
        $airport->country_id = $request->input('country_id');
        $airport->iata = $request->input('iata') ?? "";
        $airport->icao = $request->input('icao') ?? "";
        $airport->latitude = $request->input('latitude') ?? 0;
        $airport->longitude = $request->input('longitude') ?? 0;
        $airport->timezone = $request->input('timezone') ?? "";
        $airport->region_id = $request->input('region_id');

        $airport->save();

        return redirect()
            ->route('admin.airports.index')
            ->with('status', 'The airport was successfully created.');
    }


    /**
     * Store data from csv file.
     *
     * @param  \App\Http\Requests\Admin\StoreAirport  $request
     * @return \Illuminate\Http\Response
     */
    public function csvStore()
    {
        ini_set('max_execution_time', 8000000);
        Airport::whereNotNull('id')->delete();

        $data = file_get_contents("http://ourairports.com/data/airports.csv");
        $rows = explode("\n",$data);
        $airport_records = [];
        $now = Carbon::now();

        foreach(array_chunk($rows, 500) as $row) {
            foreach($row as $key => $val) {
                if($key === 0) continue;
                $airport_data = str_getcsv($val);
                if(count($airport_data) >= 10 && $airport_data[2] != "closed" && $airport_data[2] != "heliport"){
                    $airport_records[] = [
                        'source_id' => (int)$airport_data[0],
                        'name' => (string)$airport_data[3],
                        'city' => (string)$airport_data[10],
                        'country_id' => Country::where('a2', (string)$airport_data[8])->first()?Country::where('a2', (string)$airport_data[8])->first()->id:0,
                        'iata' => substr((string)$airport_data[13], 0, 3),
                        'latitude' => (float)$airport_data[4],
                        'longitude' => (float)$airport_data[5],
                        'timezone' => '',
                        'updated_at' => $now,
                        'created_at' => $now
                    ];
                }
            }
            Airport::insert($airport_records);
            $airport_records = [];
        }

        return redirect()
            ->route('admin.airports.index')
            ->with('status', 'The database was successfully updated.');
    }



    public function import()
    {
        ini_set('max_execution_time', 8000000);
        Airport::whereNotNull('id')->delete();

        $status = "CSV file was not uploaded";

        if(request()->file('file') && request()->file('file')->getClientOriginalExtension() == 'csv'){

            $data = fopen(request()->file('file'), "r");
            $column = fgetcsv($data);
            $rows = [];
            $airport_records = [];
            $now = Carbon::now();
            $delimiter = ",";

            while(!feof($data)){
                if (strpos($column[0], ",") !== false) {
                    $delimiter = ",";
                } elseif (strpos($column[0], ";") !== false) {
                    $delimiter = ";";
                }

                $rows[] = fgetcsv($data, null, $delimiter);
            }

            foreach(array_chunk($rows, 500) as $row) {
                foreach($row as $val) {
                    $airport_data = $val;
                    if(is_array($airport_data) && count($airport_data) >= 10 && $airport_data[2] != "closed" && $airport_data[2] != "heliport"){

                        $airport_records[] = [
                            'source_id' => (int)$airport_data[0],
                            'name' => (string)$airport_data[3],
                            'city' => (string)$airport_data[10],
                            'country_id' => Country::where('a2', (string)$airport_data[8])->first()?Country::where('a2', (string)$airport_data[8])->first()->id:0,
                            'iata' => substr((string)$airport_data[13], 0, 3),
                            'icao' => substr((string)$airport_data[12], 0, 4),
                            'latitude' => (float)$airport_data[4],
                            'longitude' => (float)$airport_data[5],
                            'timezone' => '',
                            'area' => (string)isset($airport_data[18]) ? $airport_data[18] : '',
                            'updated_at' => $now,
                            'created_at' => $now
                        ];
                    }
                }
                Airport::insert($airport_records);
                $airport_records = [];
            }

            $status = "The database was successfully updated.";

        }

        return redirect()
            ->route('admin.airports.index')
            ->with('status', $status);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Airport  $airport
     * @return \Illuminate\Http\Response
     */
    public function show(Airport $airport)
    {
        $country = Country::find($airport->country_id);

        return view('admin.airports.view', compact('airport','country'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Airport  $airport
     * @return \Illuminate\Http\Response
     */
    public function edit(Airport $airport)
    {

        $countries = Country::all();

        return view('admin.airports.edit', compact('airport', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\UpdateAirport  $request
     * @param  \App\Models\Airport  $airport
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAirportRequest $request, Airport $airport)
    {
        //$validated = $request->validated();
        $airport->name = $request->input('name');
        $airport->city = $request->input('city');
        $airport->country_id = $request->input('country_id');
        $airport->iata = $request->input('iata') ?? "";
        $airport->icao = $request->input('icao') ?? "";
        $airport->latitude = $request->input('latitude') ?? 0;
        $airport->longitude = $request->input('longitude') ?? 0;
        $airport->timezone = $request->input('timezone') ?? "";
        $airport->region_id = $request->input('region_id');
        $airport->save();

        return redirect()
            ->route('admin.airports.index', $airport->id)
            ->with('status', 'The airport was successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Airport  $airport
     * @return \Illuminate\Http\Response
     */
    public function destroy(Airport $airport)
    {
        $airport->delete();

        return redirect()
            ->route('admin.airports.index')
            ->with('status', 'The airport was successfully deleted.');
    }

    public function search(Request $request)
    {
        if($request->ajax())
        {
            $query = $request->get('query');
            $query = str_replace(" ", "%", $query);
            $airports = DB::table('airports')
                ->where('name', 'like', '%'.$query.'%')
                ->orWhere('city', 'like', '%'.$query.'%')
                ->orWhere('iata', 'like', '%'.$query.'%')
                ->orWhere('icao', 'like', '%'.$query.'%')
                ->orWhere('latitude', 'like', '%'.$query.'%')
                ->orWhere('longitude', 'like', '%'.$query.'%')
                ->orWhere('timezone', 'like', '%'.$query.'%')
                ->orWhere('area', 'like', '%'.$query.'%')
                ->orderBy('id', 'asc')
                ->paginate(25);
            return view('admin.airports.pagination', compact('airports'))->render();
        }
    }

}
