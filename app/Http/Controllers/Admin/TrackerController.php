<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CargoLocation;
use App\Models\Order;
use App\Models\Tracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TrackerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::any(['SuperUser','Manager','OPS','Agent','Driver'], Auth::user())) {
            $title = 'All Tracker';
            $orders = Order::with('cargo','user')->get();
            return view('backend.tracker.index',compact('title','orders'));
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
        if (Gate::any(['SuperUser','Manager','OPS'], Auth::user())) {
        $cargo_location = CargoLocation::all();
        $orders = Order::all();
        return view('backend.tracker.create', compact('cargo_location','orders'));
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
        if (Gate::any(['SuperUser','Manager','OPS'], Auth::user())) {

            foreach ($request->time as $item){
                $tracker = new Tracker();

                $tracker->order_id = $request->order_id;
                $tracker->start_time =  str_replace('T',' ',$item['start_time']);
                $tracker->location_id = $item['cargo_location'];

                $tracker->save();
            }
            return redirect()->route('admin.tracker.index');
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
        if (Gate::any(['SuperUser','Manager','OPS'], Auth::user())) {

            $trackers = Tracker::with('cargolocation')->where('order_id', $id)->get();
            $id = intval($id);
            return view('backend.tracker.show',compact('trackers','id'));
        }
        return  abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::any(['SuperUser','Manager','OPS'], Auth::user())) {
            $trackers = Tracker::with('cargolocation')->where('order_id', $id)->get();
            $id = intval($id);
            $cargo_location = CargoLocation::all();
            $orders = Order::all();
            return view('backend.tracker.edit',compact('trackers','id','orders','cargo_location'));
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
        if (Gate::any(['SuperUser','Manager','OPS'], Auth::user())) {
            foreach($request->time as $option_key) {
                if ($option_key['id']) {
                    $tracker = Tracker::findOrFail($option_key['id']);
                    $tracker->order_id = $request->order_id;
                    $tracker->location_id = $option_key['cargo_location'];
                    if (!is_null($option_key['start_time'])){
                        $tracker->start_time = str_replace('T', ' ', $option_key['start_time']);
                    }
                    if (!is_null($option_key['end_time'])){
                        $tracker->end_time = str_replace('T', ' ', $option_key['end_time']);
                    }
                    $tracker->update();
                } else {
                    $tracker = new Tracker();
                    $tracker->order_id = $request->order_id;
                    $tracker->location_id = $option_key['cargo_location'];
                    if (!is_null($option_key['start_time'])){
                        $tracker->start_time = str_replace('T', ' ', $option_key['start_time']);
                    }
                    if (!is_null($option_key['end_time'])){
                        $tracker->end_time = str_replace('T', ' ', $option_key['end_time']);
                    }
                    $tracker->save();
                }
            }
            return redirect()->route('admin.tracker.index');
        }
        return  abort(403);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function remove_tracker(Request $request){
        if (Gate::any(['SuperUser','Manager','OPS'], Auth::user())) {
            $tracker = Tracker::where('id',$request->tracker)->first();
            if (is_null($tracker)){
                return true;
            }
            $tracker->delete();
            return true;
        }
        return  abort(403);
    }

    public function destroy($id)
    {
        //
    }
}
