<?php

namespace App\Http\Controllers\Admin;

use App\Models\Fees;
use App\Models\Pricing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreFees as StoreFeesRequest;
use App\Http\Requests\Admin\UpdateFees as UpdateFeesRequest;
use Carbon\Carbon;
use DB;

class FeesController extends Controller
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
        $feeses = Fees::paginate(25);

        return view('admin.fees.list', compact('feeses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.fees.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\StorePricing $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFeesRequest $request)
    {
        $fees = new Fees;

        $fees->item = $request->input('item');
        $fees->amount = $request->input('amount');
        $fees->type = $request->input('type');
        $fees->sall = $request->input('sall')?$request->input('sall'):0;
        $fees->active = $request->input('active');

        $fees->save();

        return redirect()
            ->route('admin.fees.index')
            ->with('status', 'The additional fees was successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pricing  $pricing
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fees = Fees::find($id);

        return view('admin.fees.view', compact('fees'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pricing  $pricing
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fees = Fees::find($id);
        
        //echo "<pre>";
        //print_r($fees);
        //echo "</pre>";
        //echo $request->input('item');
        
        return view('admin.fees.edit', compact('fees'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\UpdatePricing  $request
     * @param  \App\Models\Pricing  $pricing
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        //echo $request->input('item');
        //exit();
        $fees = Fees::find($id);
        
        $fees->item = $request->input('item');
        $fees->amount = $request->input('amount');
        $fees->type = $request->input('type');
        $fees->sall = $request->input('sall')?$request->input('sall'):0;
        $fees->active = $request->input('active');

        $fees->save();

        return redirect()
            ->route('admin.fees.index', $fees->id)
            ->with('status', 'The additional fees was successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pricing  $pricing
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fees = Fees::find($id);
        $fees->delete();

        return redirect()
            ->route('admin.fees.index')
            ->with('status', 'The additional fees was successfully deleted.');
    }

}
