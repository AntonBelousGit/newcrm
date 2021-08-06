<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Cargo;
use App\Models\CargoLocation;
use App\Models\Order;
use App\Models\ProductStatus;
use App\Models\Tracker;
use App\Models\User;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::any(['SuperUser','Manager','OPS','Agent','Driver'], Auth::user())) {
            $orders = Order::with('cargo','user','tracker.cargolocation')->get();
            $title = 'All Shipments';
            return view('backend.shipments.index',compact('orders','title'));
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
            $user = User::all();
            $cargo_location = CargoLocation::all();
            return view('backend.shipments.create',compact('user','cargo_location'));
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
//            dd($request);
            $order = new Order();
            $order->shipper = $request->shipper;
            $order->phone_shipper = $request->phone_shipper;
            $order->company_shipper = $request->company_shipper;
            $order->consignee = $request->consignee;
            $order->phone_consignee = $request->phone_consignee;
            $order->shipper_address_id = $request->shipper_address_id;
            $order->consignee_address_id = $request->consignee_address_id;
            $order->company_consignee = $request->company_consignee;
            $order->shipment_description = $request->shipment_description;
            $order->comment = $request->comment;
            $order->sending_time = $request->sending_time;
            $order->delivery_time = $request->delivery_time;
            $order->delivery_comment = $request->delivery_comment;
            $order->user = $request->user;
            $order->sensor_for_rent = $request->sensor_for_rent ?? 'off';
            $order->container = $request->container ?? 'off';
            $order->return_sensor = $request->return_sensor ?? 'off';
            $order->return_container = $request->return_container ?? 'off';
            $order->notifications = $request->notifications ?? 'off';
            $order->status_id = 1;
            $order->cargo_location_id = 1;

            $order->save();

            $order->invoice_number = $order->id;

            if($request->shipper_address_id){
                $start_tracker = new Tracker;
                $start_tracker->order_id = $order->id;
                $start_tracker->location_id = $request->shipper_address_id;
                $start_tracker->address = $request->address_shipper;
                $start_tracker->start_time = $request->sending_time;
                $start_tracker->position = '0';
                $start_tracker->save();
            }
            if($request->consignee_address_id){
                $start_tracker = new Tracker;
                $start_tracker->order_id = $order->id;
                $start_tracker->location_id = $request->consignee_address_id;
                $start_tracker->address = $request->address_consignee;
                $start_tracker->start_time = $request->delivery_time;
                $start_tracker->position = '2';
                $start_tracker->save();
            }

            $order->update();



            foreach ($request->Package as $item){

                $cargo = new Cargo();
                $cargo->order_id = $order->id;
                $cargo->type = $item['type'];
                $cargo->actual_weight = $item['actual_weight'];
                $cargo->quantity = $item['quantity'];
                $cargo->serial_number = $item['serial_number'];
                $cargo->serial_number_sensor = $item['serial_number_sensor'];
                $cargo->un_number = $item['un_number'];
                $cargo->temperature_conditions = $item['temperature_conditions'];
                $cargo->сargo_dimensions_length = $item['сargo_dimensions_length'];
                $cargo->сargo_dimensions_width = $item['сargo_dimensions_width'];
                $cargo->сargo_dimensions_height = $item['сargo_dimensions_height'];
                $cargo->volume_weight =  ($item['сargo_dimensions_height']  * $item['сargo_dimensions_width'] * $item['сargo_dimensions_length'])/6000;
                $cargo->save();
            }
            return redirect()->route('admin.orders.index');
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
        $orders = Order::with('cargo','user','status','cargolocation','agent','driver')->findOrFail($id);
        return view('backend.shipments.show',compact('orders'));
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
            $orders = Order::with('cargo','user','status','cargolocation','tracker')->find($id);
            $user = User::all();
            $trackers = Tracker::with('cargolocation')->where('order_id',$id)->where('position','1')->get();
            $tracker_start = Tracker::with('cargolocation')->where('order_id',$id)->where('position','0')->first();
            $tracker_end = Tracker::with('cargolocation')->where('order_id',$id)->where('position','2')->first();
            $status = ProductStatus::all();
            $cargo_location = CargoLocation::all();
            return view('backend.shipments.edit',compact('orders','user','status','cargo_location','trackers','tracker_start','tracker_end'));
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

//           dd($request);
            $order = Order::with('cargo')->findOrFail($id);

            $order->shipper = $request->shipper;
            $order->phone_shipper = $request->phone_shipper;
            $order->company_shipper = $request->company_shipper;
            $order->consignee = $request->consignee;
            $order->phone_consignee = $request->phone_consignee;
            $order->company_consignee = $request->company_consignee;
            $order->shipment_description = $request->shipment_description;
            $order->comment = $request->comment;
            $order->sending_time = $request->sending_time;
            $order->delivery_time = $request->delivery_time;
            $order->delivery_comment = $request->delivery_comment;
            $order->user = $request->user;
            $order->sensor_for_rent = $request->sensor_for_rent ?? 'off';
            $order->container = $request->container ?? 'off';
            $order->return_sensor = $request->return_sensor ?? 'off';
            $order->return_container = $request->return_container ?? 'off';
            $order->notifications = $request->notifications ?? 'off';
            $order->status_id = $request->status_id;
            $order->agent_id = $request->agent_id ?? null;
            $order->driver_id = $request->driver_id ?? null;



            $order->cargo_location_id = $request->cargo_location_id ?? 1;

            $order->update();

            foreach($request->Package as $option_key){
                if ($option_key['id']){
                    $cargo = Cargo::findOrFail($option_key['id']);
                    $cargo->type = $option_key['type'];
                    $cargo->quantity = $option_key['quantity'];
                    $cargo->serial_number = $option_key['serial_number'];
                    $cargo->serial_number_sensor = $option_key['serial_number_sensor'];
                    $cargo->un_number = $option_key['un_number'];
                    $cargo->temperature_conditions = $option_key['temperature_conditions'];
                    $cargo->сargo_dimensions_length = $option_key['сargo_dimensions_length'];
                    $cargo->сargo_dimensions_width = $option_key['сargo_dimensions_width'];
                    $cargo->сargo_dimensions_height = $option_key['сargo_dimensions_height'];
                    $cargo->volume_weight = ($option_key['сargo_dimensions_height']  * $option_key['сargo_dimensions_width'] * $option_key['сargo_dimensions_length'])/6000;
                    $cargo->update();
                }
                else{
                    $cargo = new Cargo();
                    $cargo->order_id = $order->id;
                    $cargo->type = $option_key['type'];
                    $cargo->actual_weight = $option_key['actual_weight'];
                    $cargo->quantity = $option_key['quantity'];
                    $cargo->serial_number = $option_key['serial_number'];
                    $cargo->serial_number_sensor = $option_key['serial_number_sensor'];
                    $cargo->un_number = $option_key['un_number'];
                    $cargo->temperature_conditions = $option_key['temperature_conditions'];
                    $cargo->сargo_dimensions_length = $option_key['сargo_dimensions_length'];
                    $cargo->сargo_dimensions_width = $option_key['сargo_dimensions_width'];
                    $cargo->сargo_dimensions_height = $option_key['сargo_dimensions_height'];
                    $cargo->volume_weight =  ($option_key['сargo_dimensions_height']  * $option_key['сargo_dimensions_width'] * $option_key['сargo_dimensions_length'])/6000;
                    $cargo->save();
                }
            }
//            dd($request);
            if (isset($request->time)){
                foreach($request->time as $option_key) {
                    if (isset($option_key['id'])) {
                        $tracker = Tracker::findOrFail($option_key['id']);
                        $tracker->order_id = $order->id;
                        $tracker->location_id = $option_key['cargo_location'];
                        $tracker->address = $option_key['address'];
                        if (!is_null($option_key['start_time'])){
                            $tracker->start_time = str_replace('T', ' ', $option_key['start_time']);
                        }
                        if (!is_null($option_key['end_time'])){
                            $tracker->end_time = str_replace('T', ' ', $option_key['end_time']);
                        }
                        $tracker->status = $option_key['status'];
                        $tracker->update();
                    } else {
                        $tracker = new Tracker();
                        $tracker->order_id = $order->id;
                        $tracker->location_id = $option_key['cargo_location'];
                        $tracker->address = $option_key['address'];
                        if (!is_null($option_key['start_time'])){
                            $tracker->start_time = str_replace('T', ' ', $option_key['start_time']);
                        }
                        if (!is_null($option_key['end_time'])){
                            $tracker->end_time = str_replace('T', ' ', $option_key['end_time']);
                        }
                        $tracker->status = $option_key['status'];
                        $tracker->save();
                    }
                }
            }

            if ($request->start){
                $tracker_start = Tracker::with('cargolocation')->where('order_id',$order->id)->where('position','0')->first();
                $start = $request->start;
                if (!is_null($start['start_time'])){
                    $tracker_start->start_time = str_replace('T', ' ', $start['start_time']);
                }
                if (!is_null($start['end_time'])){
                    $tracker_start->end_time = str_replace('T', ' ', $start['end_time']);
                }
                $tracker_start->status = $start['status'];

                $tracker_start->update();
            }
            if ($request->end){
                $tracker_end = Tracker::with('cargolocation')->where('order_id',$order->id)->where('position','0')->first();
                $end = $request->start;
                if (!is_null($end['start_time'])){
                    $tracker_end->start_time = str_replace('T', ' ', $end['start_time']);
                }
                if (!is_null($end['end_time'])){
                    $tracker_end->end_time = str_replace('T', ' ', $end['end_time']);
                }
                $tracker_end->status = $end['status'];
                $tracker_end->update();
            }
            if($request->shipper_address_id){
                $tracker_start = Tracker::with('cargolocation')->where('order_id',$order->id)->where('position','0')->first();
                $tracker_start->location_id = $request->shipper_address_id;
                $tracker_start->address = $request->address_shipper;
                $tracker_start->start_time = $request->sending_time;
                $tracker_start->update();
            }
            if($request->consignee_address_id){
                $tracker_end = Tracker::with('cargolocation')->where('order_id',$order->id)->where('position','2')->first();
                $tracker_end->location_id = $request->consignee_address_id;
                $tracker_end->address = $request->address_consignee;
                $tracker_end->start_time = $request->delivery_time;
                $tracker_end->update();
            }

            return redirect()->route('admin.orders.index');
        }
        elseif (Gate::any(['Agent','Driver'],Auth::user())){
            dd($request);
        }
        return  abort(403);
    }
    public function remove_cargo(Request $request ){
        if (Gate::any(['SuperUser','Manager','OPS'], Auth::user())) {
            $cargo = Cargo::where('order_id',$request->order)->where('id',$request->cargo)->first();
            if (is_null($cargo)){
                return true;
            }
            $cargo->delete();
            return true;
        }
        return  abort(403);
    }

    public function new_order(){

        if (Gate::any(['SuperUser','Manager','OPS','Agent'], Auth::user())) {
            $orders = Order::with('cargo','user','agent','driver')->where('status_id',1)->get();
            $title = 'New order';
            return view('backend.shipments.index',compact('orders','title'));
        }
        return  abort(403);
    }

    public function in_processing(){
        if (Gate::any(['SuperUser','Manager','OPS','Agent'], Auth::user())) {
            $orders = Order::with('cargo','user','agent')->where('status_id',2)->get();

            $title = 'In processing';
            return view('backend.shipments.index',compact('orders','title'));
        }
        return  abort(403);
    }

    public function in_work(){
        if (Gate::any(['SuperUser','Manager','OPS'], Auth::user())) {
            $orders = Order::with('cargo','user','agent','driver')->where('status_id',3)->get();
            $title = 'Accepted in work';
            return view('backend.shipments.index',compact('orders','title'));
        }
        if (Gate::any(['Agent','Driver'], Auth::user())){
            $orders = Order::with('cargo','user','agent','driver')->where('status_id',3)->get();
            $title = 'Accepted in work';
            return view('backend.shipments.index',compact('orders','title'));

        }
        return  abort(403);
    }
    public function delivered(){
        if (Gate::any(['SuperUser','Manager','OPS','Agent'], Auth::user())) {
            $orders = Order::with('cargo','user','agent')->where('status_id',4)->get();
            $title = 'Delivered';
            return view('backend.shipments.index',compact('orders','title'));
        }
        return  abort(403);
    }
    public function edit_agent_driver($id){
        if (Gate::any(['Agent','Driver'], Auth::user())){
            $orders = Order::with('cargo','user','status','cargolocation','tracker')->find($id);
            $user = User::all();
            $trackers = Tracker::with('cargolocation')->where('order_id',$id)->where('position','1')->get();
            $tracker_start = Tracker::with('cargolocation')->where('order_id',$id)->where('position','0')->first();
            $tracker_end = Tracker::with('cargolocation')->where('order_id',$id)->where('position','2')->first();
            $status = ProductStatus::all();
            $cargo_location = CargoLocation::all();

            return view('backend.shipments.edit-driver-agent',compact('orders','user','status','cargo_location','trackers','tracker_start','tracker_end'));
        }
        return  abort(403);
    }
    public function update_agent_driver_tracker(Request $request,$id){

        $orders = Order::find($id);
            if (Gate::any(['manage-agent','manage-driver'],$orders)){
//                dd($request);

                if (isset($request->start)){
                    if (isset($request->start['status_arrival'])){
                        $tracker_start = Tracker::with('cargolocation')->where('order_id',$id)->where('position','0')->first();
                            if ($tracker_start->status == 'Arrival'){
                                return abort(403);
                            }
                        $tracker_start->end_time = now();
                        $tracker_start->status = 'Arrived';

                            if ($tracker_start->end_time > $tracker_start->start_time )
                            {
                                $tracker_start->alert = 'bad';
                            }
                        $tracker_start->update();
                    }
                }
                if ($request->end){
                    if (isset($request->end['status_arrival'])){
                        $tracker_end = Tracker::with('cargolocation')->where('order_id',$id)->where('position','2')->first();
                        if ($tracker_end->status == 'Arrival'){
                            return abort(403);
                        }
                        $tracker_end->end_time = now();
                        $tracker_end->status = 'Arrived';

                        if ($tracker_end->end_time > $tracker_end->start_time )
                        {
                            $tracker_end->alert = 'bad';
                        }
                        $tracker_end->update();
                    }
                }
                if (isset($request->time)){
                    foreach($request->time as $option_key) {
                        if (isset($option_key['id']) &&  isset($option_key['status_arrival'])) {
                            $tracker = Tracker::where('order_id',$id)->findOrFail($option_key['id']);
                                if ($tracker->status == 'Arrival'){
                                    return abort(403);
                                }
                            $tracker->end_time = now();
                            $tracker->status = 'Arrived';
                                if ($tracker->end_time > $tracker->start_time)
                                {
                                    $tracker->alert = 'bad';
                                }

                                $tracker->update();
                        }
                    }
                }
                return redirect()->route('admin.orders.in_work');

            }
//        dd($tracker_start);
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
