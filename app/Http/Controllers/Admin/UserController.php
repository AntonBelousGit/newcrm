<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Models\Activity;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::any(['SuperUser', 'Manager', 'Security Officer'], Auth::user())) {
            $users = User::where('id', '!=', 1)->get();
            $logs = Activity::with('user', 'client')->whereIn('log_name', ['User', 'Role'])->orderBy('created_at', 'DESC')->get();
            return view('backend.clients.index', compact('users', 'logs'));
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
        if (Gate::any(['SuperUser', 'Manager', 'Security Officer'], Auth::user())) {
            $roles = Role::where('id', '!=', 1)->get();
            $companies = Company::all();
            return view('backend.clients.create', compact('roles','companies'));
        }
        return abort(403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function store(Request $request)
    {
        if (Gate::any(['SuperUser', 'Manager', 'Security Officer'], Auth::user())) {
            $user = new User;

            $user->name = $request->name ?? 'User-' . random_int(100000, 99999999);
            $user->nickname = $request->nickname;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->fullname = $request->fullname;
            $user->save();

            if ($request->roles == 1) {
                return abort(403);
            }
            $user->roles()->attach($request->roles);


            if ($request->roles == 5){
                $user->company()->attach($request->company_id, ['type' => 'agent']);
            }
            if ($request->roles == 6){
                $user->company()->attach($request->company_id, ['type' => 'driver']);
            }

//            dd($user->roles);

            activity()
                ->event('created')
                ->useLog('User')
                ->causedBy(Auth::user())
                ->performedOn($user)
                ->withProperties(['status' => $user, 'rol' => $user->roles->pluck('name')->first()])
                ->log('created');


            return redirect()->route('admin.users.index');
        }
        return abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::any(['SuperUser', 'Manager', 'Security Officer'], Auth::user())) {
            $users = User::where('id', $id)->with('roles')->first();

            return view('backend.clients.show', compact('users'));
        }
        return abort(403);
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
            $user = User::find($id);
            $roles = Role::where('id', '!=', 1)->get();
            $companies = Company::all();
            return view('backend.clients.edit', compact('user', 'roles','companies'));
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
        if (Gate::any(['SuperUser', 'Manager', 'Security Officer'], Auth::user())) {

            $user = User::find($id);

            $user->name = $request->name;
            $user->nickname = $request->nickname;
            $user->email = $request->email;
            $user->fullname = $request->fullname;
            if (!empty($request->password)) {
                $user->password = Hash::make($request->password);
            }
            $user->update();

            if ($request->roles == 1) {
                return abort(403);
            }

            $user->roles()->sync($request->roles);
            $user->company()->sync([]);

            if ($request->roles == 5){
                $user->company()->attach($request->company_id, ['type' => 'agent']);
            }
            if ($request->roles == 6){
                $user->company()->attach($request->company_id, ['type' => 'driver']);
            }

            return redirect()->route('admin.users.index');
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
        if (Gate::any(['SuperUser', 'Manager', 'Security Officer'], Auth::user())) {
            $user = User::find($id);
            $user->delete();
            return redirect()->route('admin.users.index');
        }
        return abort(403);

    }

    public function deleteClient($id)
    {
        if (Gate::any(['SuperUser', 'Manager', 'Security Officer'], Auth::user())) {
            $user = User::find($id);
            $user->delete();
            return redirect()->route('admin.users.index');
        }
        return abort(403);
    }

    public function editClient()
    {
            $user = User::find(Auth::id());
            return view('backend.clients.edit-client', compact('user'));
    }

    public function updateClient(Request $request)
    {
            $user = User::find(Auth::id());
            if (!empty($request->password)) {
                $user->password = Hash::make($request->password);
            }
            $status = $user->update();

            if ($status) {
                return back()->with('success', 'Successfully updated');
            }

        return back()->with('error', 'Something went wrong!');

    }

    public function statusClient($id)
    {
        $user = User::find($id);
        if ($user->status == 'inactive') {
            DB::table('users')->where('id', $id)->update(['status' => 'active']);
        } else {
            DB::table('users')->where('id', $id)->update(['status' => 'inactive']);
        }

        return back()->with(['msg' => 'Successfully updated status', 200]);
    }
}
