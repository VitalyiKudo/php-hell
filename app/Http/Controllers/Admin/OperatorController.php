<?php

namespace App\Http\Controllers\Admin;

use App\Models\Operator;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Imports\OperatorImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOperator as StoreOperatorRequest;
use App\Http\Requests\Admin\UpdateOperator as UpdateOperatorRequest;
use Carbon\Carbon;
use DB;

class OperatorController extends Controller
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
    public function store(StoreOperatorRequest $request)
    {
        $operator = new Operator;

        $operator->name = $request->input('name');
        $operator->web_site = $request->input('web_site');
        $operator->email = $request->input('email');
        $operator->phone = $request->input('phone');
        $operator->mobile = $request->input('mobile');
        $operator->fax = $request->input('fax');
        $operator->address = $request->input('address');

        $operator->save();

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
        if(request()->file('file') && request()->file('file')->extension() == 'xlsx'){
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
        return view('admin.operators.edit', compact('operator'));
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
        $operator->name = $request->input('name');
        $operator->web_site = $request->input('web_site');
        $operator->email = $request->input('email');
        $operator->phone = $request->input('phone');
        $operator->mobile = $request->input('mobile');
        $operator->fax = $request->input('fax');
        $operator->address = $request->input('address');

        $operator->save();

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
        if($request->ajax())
        {
            $query = $request->get('query');
            $query = str_replace(" ", "%", $query);
            $operators = DB::table('operators') 
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
    
}
