<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::any(['SuperUser','Manager','Security Officer'], Auth::user())){
            $payers = Payer::all();
            $title = 'All payers';
            return view('backend.payer.index',compact('payers','title'));
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
        if (Gate::any(['SuperUser','Manager','Security Officer'], Auth::user())) {
            return view('backend.payer.create');
        }
        return  abort(403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (Gate::any(['SuperUser','Manager','Security Officer'], Auth::user())) {
            $payer = new Payer;
            $payer->customer_account_number = $request->customer_account_number;
            $payer->customer_name = $request->customer_name;
            $payer->customer_address = $request->customer_address;
            $payer->city = $request->city;
            $payer->zip_code = $request->zip_code;
            $payer->country = $request->country;
            $payer->contact_name = $request->contact_name;
            $payer->phone = $request->phone;
            $payer->email = $request->email;
            $payer->billing = $request->billing ?? '';
            $payer->special = $request->special ?? '';

            $payer->save();

            return redirect()->route('admin.payer.index');
        }
        return  abort(403);
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
            $payer = Payer::find($id);
            return view('backend.payer.edit',compact('payer'));
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
        if (Gate::any(['SuperUser','Manager','Security Officer'], Auth::user())) {
            $payer = Payer::find($id);
            $payer->customer_account_number = $request->customer_account_number;
            $payer->customer_name = $request->customer_name;
            $payer->customer_address = $request->customer_address;
            $payer->city = $request->city;
            $payer->zip_code = $request->zip_code;
            $payer->country = $request->country;
            $payer->contact_name = $request->contact_name;
            $payer->phone = $request->phone;
            $payer->email = $request->email;
            $payer->billing = $request->billing ?? '';
            $payer->special = $request->special ?? '';

            $payer->update();

            return redirect()->route('admin.payer.index');
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
        $payer = Payer::find($id);
        $payer->delete();
        return redirect()->route('admin.payer.index');

    }

    public function showClient()
    {
        if(Gate::any(['SuperUser','Manager','Security Officer'], Auth::user())){
            $users = User::whereHas('roles', function($q)
            {
                $q->where('name', 'Client');
            })->get();
            return view('backend.payer.client',compact('users'));
        }
        return  abort(403);
    }
    public function clientPayerEdit($id)
    {
        if(Gate::any(['SuperUser','Manager','Security Officer'], Auth::user())){
            $users = User::find($id);

            return view('backend.payer.client',compact('users'));
        }
        return  abort(403);
    }
    public function clientPayerUpdate(Request $request,$id)
    {
        if(Gate::any(['SuperUser','Manager','Security Officer'], Auth::user())){

            return  redirect()->route('admin.payer.index');
        }
        return  abort(403);
    }
}
