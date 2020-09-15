<?php

namespace App\Http\Controllers\Admin;

use App\Models\Airline;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Imports\AirlineImport;
use Maatwebsite\Excel\Facades\Excel;
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
     * @param  \App\Http\Requests\Admin\StoreAirline $request
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
     * Store data from excel file.
     *
     * @param  \App\Http\Requests\Admin\StoreAirline  $request
     * @return \Illuminate\Http\Response
     */

    public function import() 
    {
        $status = "Excel file was not uploaded";
        if(request()->file('file') && request()->file('file')->extension() == 'xlsx'){
            Airline::whereNotNull('id')->delete();
            Excel::import(new AirlineImport, request()->file('file'));
            $status = "The database was successfully updated.";
        }

        return redirect()
            ->route('admin.airlines.index')
            ->with('status', $status);
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
