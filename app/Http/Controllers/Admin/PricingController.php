<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pricing;
use App\Models\Country;
use App\Models\Airport;
use App\Models\Operator;
use Illuminate\Http\Request;
use App\Imports\PricingImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePricing as StorePricingRequest;
use App\Http\Requests\Admin\UpdatePricing as UpdatePricingRequest;
use Carbon\Carbon;
use DB;

class PricingController extends Controller
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
        $pricing = Pricing::paginate(25);

        return view('admin.pricing.list', compact('pricing'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pricing.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\StorePricing $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePricingRequest $request)
    {
        
        //echo $request->input('time_turbo');
        //exit();
        
        $pricing = new Pricing;

        $pricing->departure = $request->input('departure');
        $pricing->arrival = $request->input('arrival');
        $pricing->time_turbo = $request->input('time_turbo') ?? "";
        $pricing->price_turbo = $request->input('price_turbo');
        $pricing->time_light = $request->input('time_light');
        $pricing->price_light = $request->input('price_light');
        $pricing->time_medium = $request->input('time_medium');
        $pricing->price_medium = $request->input('price_medium');
        $pricing->time_heavy = $request->input('time_heavy');
        $pricing->price_heavy = $request->input('price_heavy');

        $pricing->save();

        return redirect()
            ->route('admin.pricing.index')
            ->with('status', 'The pricing was successfully created.');
    }
    
    /**
     * Store data from excel file.
     *
     * @param  \App\Http\Requests\Admin\StorePricing  $request
     * @return \Illuminate\Http\Response
     */

    public function import() 
    {
        $status = "Excel file was not uploaded";
        
        if(request()->file('file') && request()->file('file')->extension() == 'xlsx'){
            Pricing::whereNotNull('id')->delete();
            Excel::import(new PricingImport, request()->file('file'));
            $status = "The database was successfully updated.";
        }

        return redirect()
            ->route('admin.pricing.index')
            ->with('status', $status);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pricing  $pricing
     * @return \Illuminate\Http\Response
     */
    public function show(Pricing $pricing)
    {
        return view('admin.pricing.view', compact('pricing'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pricing  $pricing
     * @return \Illuminate\Http\Response
     */
    public function edit(Pricing $pricing)
    {
        //echo "<pre>";
        //print_r($pricing);
        //echo "</pre>";
        return view('admin.pricing.edit', compact('pricing'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\UpdatePricing  $request
     * @param  \App\Models\Pricing  $pricing
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePricingRequest $request, Pricing $pricing)
    {
        $pricing->departure = $request->input('departure');
        $pricing->arrival = $request->input('arrival');
        $pricing->time_turbo = $request->input('time_turbo') ?? "";
        $pricing->price_turbo = $request->input('price_turbo');
        $pricing->time_light = $request->input('time_light');
        $pricing->price_light = $request->input('price_light');
        $pricing->time_medium = $request->input('time_medium');
        $pricing->price_medium = $request->input('price_medium');
        $pricing->time_heavy = $request->input('time_heavy');
        $pricing->price_heavy = $request->input('price_heavy');

        $pricing->save();

        return redirect()
            ->route('admin.pricing.index', $pricing->id)
            ->with('status', 'The pricing was successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pricing  $pricing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pricing $pricing)
    {
        $pricing->delete();

        return redirect()
            ->route('admin.pricing.index')
            ->with('status', 'The pricing was successfully deleted.');
    }

    public function getAutocompleteAirports(Request $request){
        if($request->get('query')){
            $query = $request->get('query');
            $data = Airport::where('name','like',$query.'%')->get();
              
            $output = '<ul class="dropdown-menu" style="display:block; position:absolute"">';
            foreach($data as $row)
            {
                $output .= '<li><a href="#">'.$row->name.'</a></li>';
            }
            $output .= '</ul>';
            echo $output;
        }
    }

    public function getAutocompleteCities(Request $request){
        if($request->get('query')){
            $query = $request->get('query');
            $data = Airport::where('city','like',$query.'%')->groupBy("city")->get();
              
            $output = '<ul class="dropdown-menu" style="display:block; position:absolute">';
            foreach($data as $row)
            {
                $output .= '<li><a href="#">'.$row->city.'</a></li>';
            }
            $output .= '</ul>';
            echo $output;
        }

    }
    
    public function getAutocompleteAreas(Request $request){
        if($request->get('query')){
            $query = $request->get('query');
            $data = Airport::where('area','like',$query.'%')->groupBy("city")->get();
              
            $output = '<ul class="dropdown-menu" style="display:block; position:absolute">';
            foreach($data as $row)
            {
                $output .= '<li><a href="#">'.$row->area.'</a></li>';
            }
            $output .= '</ul>';
            echo $output;
        }

    }
    
    public function getAutocompleteOperators(Request $request){
        if($request->get('query')){
            $query = $request->get('query');
            $data = Operator::where('name','like',$query.'%')->groupBy("name")->get();
              
            $output = '<ul class="dropdown-menu" style="display:block; position:absolute">';
            foreach($data as $row)
            {
                $output .= '<li><a href="#">'.$row->name.'</a></li>';
            }
            $output .= '</ul>';
            echo $output;
        }

    }
    
    public function search(Request $request)
    {
        if($request->ajax())
        {
            $query = $request->get('query');
            $query = str_replace(" ", "%", $query);
            $pricing = DB::table('pricings')
                ->where('departure', 'like', '%'.$query.'%')
                ->orWhere('arrival', 'like', '%'.$query.'%')
                ->orWhere('time_turbo', 'like', '%'.$query.'%')
                ->orWhere('price_turbo', 'like', '%'.$query.'%')
                ->orWhere('time_light', 'like', '%'.$query.'%')
                ->orWhere('price_light', 'like', '%'.$query.'%')
                ->orWhere('time_medium', 'like', '%'.$query.'%')
                ->orWhere('price_medium', 'like', '%'.$query.'%')
                ->orWhere('time_heavy', 'like', '%'.$query.'%')
                ->orWhere('price_heavy', 'like', '%'.$query.'%')
                ->orderBy('id', 'asc')
                ->paginate(25);
            return view('admin.pricing.pagination', compact('pricing'))->render();
        }
    }

    
}
