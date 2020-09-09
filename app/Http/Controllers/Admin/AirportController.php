<?php

namespace App\Http\Controllers\Admin;

use App\Models\Airport;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAirport as StoreAirportRequest;
use App\Http\Requests\Admin\UpdateAirport as UpdateAirportRequest;

class AirportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
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
     * Display the specified resource.
     *
     * @param  \App\Models\Airport  $airport
     * @return \Illuminate\Http\Response
     */
    public function show(Airport $airport)
    {
        abort(404);
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
