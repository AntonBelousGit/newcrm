<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgentUser;
use App\Models\CargoLocation;
use App\Models\Company;
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
        if (Gate::any(['SuperUser', 'Manager', 'Security Officer'], Auth::user())) {
            $users = User::with('company')->whereHas('roles', function ($q) {
                $q->where('name', 'Agent');
            })->get();
            $title = 'All agents';
            return view('backend.agent.index', compact('users', 'title'));
        }
        return abort(403);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::any(['SuperUser', 'Manager', 'Security Officer'], Auth::user())) {
            $users = User::with('company')->where('id', $id)->whereHas('roles', function ($q) {
                $q->where('name', 'Agent');
            })->first();
            //            $company
            $cargo_location = CargoLocation::all();
            $companies = Company::all();

            return view('backend.agent.edit', compact('users', 'cargo_location', 'companies'));
        }
        return abort(403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validate_data = $this->validate($request, [
            'location_id' => 'string|nullable',
            'company_id' => 'string|nullable',
        ]);

        if (Gate::any(['SuperUser', 'Manager', 'Security Officer'], Auth::user())) {
            $users = User::with('agent')->where('id', $id)->whereHas('roles', function ($q) {
                $q->where('name', 'Agent');
            })->first();
            if (is_null($users->agent_id)) {
                $agent_user = new AgentUser();
                $agent_user->location_id = $validate_data['location_id'];
                $agent_user->save();
            } else {
                $agent_user = AgentUser::where('id', $users->agent_id)->first();
                $agent_user->location_id = $validate_data['location_id'];
                $agent_user->update();
            }

            $users->agent_id = $agent_user->id;

            $users->company()->sync([]);

            if ($validate_data['company_id']) {
                $users->company()->attach($validate_data['company_id'], ['type' => 'agent']);
            }

            $users->update();

            return redirect()->route('admin.agent.index');
        }
        return abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
