<?php

namespace App\Http\Controllers\Admin;

use App\Models\Airline;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAirline as StoreAirlineRequest;
use App\Http\Requests\Admin\UpdateAirline as UpdateAirlineRequest;
use Carbon\Carbon;

class AirlineController extends Controller
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
        $airlines = Airline::paginate(25);

        return view('admin.airlines.list', compact('airlines'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.airlines.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\StoreAirport  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAirlineRequest $request)
    {
        $airline = new Airline;

        $airline->type = $request->input('type');
        $airline->reg_number = $request->input('reg_number');
        $airline->category = $request->input('category');
        $airline->homebase = $request->input('homebase');
        $airline->max_pax = $request->input('max_pax');
        $airline->yom = $request->input('yom');
        $airline->operator = $request->input('operator');

        $airline->save();

        return redirect()
            ->route('admin.airlines.index')
            ->with('status', 'The airline was successfully created.');
    }
    
    
    /**
     * Store data from csv file.
     *
     * @param  \App\Http\Requests\Admin\StoreAirline  $request
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
            ->route('admin.airlines.index')
            ->with('status', 'The database was successfully updated.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Airline  $airline
     * @return \Illuminate\Http\Response
     */
    public function show(Airline $airline)
    {
        return view('admin.airlines.view', compact('airline'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Airline  $airline
     * @return \Illuminate\Http\Response
     */
    public function edit(Airline $airline)
    {
        return view('admin.airlines.edit', compact('airline'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\UpdateAirline  $request
     * @param  \App\Models\Airline  $airline
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAirlineRequest $request, Airline $airline)
    {
        $airline->type = $request->input('type');
        $airline->reg_number = $request->input('reg_number');
        $airline->category = $request->input('category');
        $airline->homebase = $request->input('homebase');
        $airline->max_pax = $request->input('max_pax');
        $airline->yom = $request->input('yom');
        $airline->operator = $request->input('operator');

        $airline->save();

        return redirect()
            ->route('admin.airlines.index', $airline->id)
            ->with('status', 'The airline was successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Airline  $airline
     * @return \Illuminate\Http\Response
     */
    public function destroy(Airline $airline)
    {
        $airline->delete();

        return redirect()
            ->route('admin.airlines.index')
            ->with('status', 'The airline was successfully deleted.');
    }
}
