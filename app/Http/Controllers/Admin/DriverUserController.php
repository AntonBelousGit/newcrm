<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DriverUser;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::any(['SuperUser','Manager','Security Officer'], Auth::user())){
            $users = User::with('driver')->whereHas('roles', function($q)
            {
                $q->where('name', 'Driver');
            })->get();
            $title = 'All driver';
            return view('backend.driver.index',compact('users','title'));
        }
        return  abort(403);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Gate::any(['SuperUser','Manager','Security Officer'], Auth::user())){
            $users = User::with('driver')->where('id',$id)->whereHas('roles', function($q)
            {
                $q->where('name', 'Driver');
            })->first();
            return view('backend.driver.edit',compact('users'));
        }
        return  abort(403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if(Gate::any(['SuperUser','Manager','Security Officer'], Auth::user())){
            $users = User::with('driver')->where('id',$id)->whereHas('roles', function($q)
            {
                $q->where('name', 'Driver');
            })->first();
//            dd($request);
            if (is_null($users->driver_id)){
                $driver_user = new DriverUser();
                $driver_user->car_model = $request->car_model;
                $driver_user->gos_number_car = $request->gos_number_car;
                $driver_user->save();
            }
            else
            {
                $driver_user = DriverUser::where('id',$users->driver_id)->first();
                $driver_user->car_model = $request->car_model;
                $driver_user->gos_number_car = $request->gos_number_car;
                $driver_user->update();
            }

            $users->driver_id = $driver_user->id;

            $users->update();

            return redirect()->route('admin.driver.index');
        }
        return  abort(403);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
