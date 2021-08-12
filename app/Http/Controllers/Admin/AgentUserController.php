<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgentUser;
use App\Models\CargoLocation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AgentUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::any(['SuperUser','Manager','Security Officer'], Auth::user())){
            $users = User::with('agent.location')->whereHas('roles', function($q)
            {
                $q->where('name', 'Agent');
            })->get();
            $title = 'All agents';
            return view('backend.agent.index',compact('users','title'));
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
            $users = User::with('agent')->where('id',$id)->whereHas('roles', function($q)
            {
                $q->where('name', 'Agent');
            })->first();

            $cargo_location = CargoLocation::all();

            return view('backend.agent.edit',compact('users','cargo_location'));
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
//        dd($request);
        if(Gate::any(['SuperUser','Manager','Security Officer'], Auth::user())){
            $users = User::with('agent')->where('id',$id)->whereHas('roles', function($q)
            {
                $q->where('name', 'Agent');
            })->first();
//            dd($request);
            if (is_null($users->agent_id)){
                $agent_user = new AgentUser();
                $agent_user->agent_company_name = $request->agent_company_name;
                $agent_user->location_id = $request->location_id;
                $agent_user->save();
            }
            else
            {
                $agent_user = AgentUser::where('id',$users->agent_id)->first();
                $agent_user->agent_company_name = $request->agent_company_name;
                $agent_user->location_id = $request->location_id;
                $agent_user->update();
            }

            $users->agent_id = $agent_user->id;

            $users->update();

            return redirect()->route('admin.agent.index');
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
