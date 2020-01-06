<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Administrator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\StoreAdministrator as StoreAdministratorRequest;
use App\Http\Requests\Admin\UpdateAdministrator as UpdateAdministratorRequest;

class AdministratorController extends Controller
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
        $administrators = Administrator::paginate(25);

        return view('admin.administrators.list', compact('administrators'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.administrators.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\StoreAdministrator  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdministratorRequest $request)
    {
        $administrator = new Administrator;

        $administrator->name = $request->input('name');
        $administrator->email = $request->input('email');
        $administrator->password = Hash::make($request->input('password'));

        $administrator->save();

        return redirect()
            ->route('admin.administrators.index')
            ->with('status', 'The administrator was successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Administrator  $administrator
     * @return \Illuminate\Http\Response
     */
    public function show(Administrator $administrator)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Administrator  $administrator
     * @return \Illuminate\Http\Response
     */
    public function edit(Administrator $administrator)
    {
        return view('admin.administrators.edit', compact('administrator'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\UpdateAdministrator  $request
     * @param  \App\Models\Administrator  $administrator
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdministratorRequest $request, Administrator $administrator)
    {
        $administrator->name = $request->input('name');
        $administrator->email = $request->input('email');

        if ($request->filled('password')) {
            $administrator->password = Hash::make($request->input('password'));
        }

        $administrator->save();

        return redirect()
            ->route('admin.administrators.index', $administrator->id)
            ->with('status', 'The administrator was successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Administrator  $administrator
     * @return \Illuminate\Http\Response
     */
    public function destroy(Administrator $administrator)
    {
        $administrator->delete();

        return redirect()
            ->route('admin.administrators.index')
            ->with('status', 'The administrator was successfully deleted.');
    }
}
