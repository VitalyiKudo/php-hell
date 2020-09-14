<?php

namespace App\Http\Controllers\Admin;

use App\Models\Airport;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAirport as StoreAirportRequest;
use App\Http\Requests\Admin\UpdateAirport as UpdateAirportRequest;
use Carbon\Carbon;

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
    public function index()
    {
        $airports = Airport::paginate(25);

        return view('admin.airports.list', compact('airports'));
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
        $airport->iata = $request->input('iata');
        $airport->icao = $request->input('icao');
        $airport->latitude = $request->input('latitude');
        $airport->longitude = $request->input('longitude');
        $airport->timezone = $request->input('timezone');

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
        $airport->iata = $request->input('iata');
        $airport->icao = $request->input('icao');
        $airport->latitude = $request->input('latitude');
        $airport->longitude = $request->input('longitude');
        $airport->timezone = $request->input('timezone');

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
}
