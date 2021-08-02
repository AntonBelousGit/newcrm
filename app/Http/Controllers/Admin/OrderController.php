<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cargo;
use App\Models\CargoLocation;
use App\Models\Order;
use App\Models\ProductStatus;
use App\Models\User;
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
            $orders = Order::with('cargo','user')->get();
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
        return view('backend.shipments.create',compact('user'));
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
            $order = new Order();

            $order->shipper = $request->shipper;
            $order->phone_shipper = $request->phone_shipper;
            $order->address_shipper = $request->address_shipper;
            $order->company_shipper = $request->company_shipper;
            $order->consignee = $request->consignee;
            $order->phone_consignee = $request->phone_consignee;
            $order->address_consignee = $request->address_consignee;
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

            return redirect()->route('admin.index');
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
            $orders = Order::with('cargo','user','status','cargolocation')->findOrFail($id);
        //        dd($orders);
            $user = User::all();
            $agent = User::with('roles')->get();
//            dd($agent);

            $status = ProductStatus::all();
            $cargo_location = CargoLocation::all();
            return view('backend.shipments.edit',compact('orders','user','status','cargo_location'));
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
            $order->address_shipper = $request->address_shipper ?? $order->address_shipper;
            $order->company_shipper = $request->company_shipper;
            $order->consignee = $request->consignee;
            $order->phone_consignee = $request->phone_consignee;
            $order->address_consignee = $request->address_consignee ?? $order->address_consignee;
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
            $order->agent_id = $request->agent_id ?? '';
            $order->driver_id = $request->driver_id ?? '';



            $order->cargo_location_id = $request->cargo_location_id;

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

            return redirect()->route('admin.orders.index');
        }
        return  abort(403);
    }

    public function remove_cargo(Request $request ){
        if (Gate::any(['SuperUser','Manager','OPS'], Auth::user())) {
            $cargo = Cargo::where('order_id',$request->order)->where('id',$request->cargo)->first();
            $cargo->delete();
            return true;
        }
        return  abort(403);
    }

    public function new_order(){

        if (Gate::any(['SuperUser','Manager','OPS','Agent'], Auth::user())) {
            $orders = Order::with('cargo','user','agent','driver')->where('status_id',1)->paginate(10);
            $title = 'New order';
            return view('backend.shipments.index',compact('orders','title'));
        }
        return  abort(403);
    }

    public function in_processing(){
        if (Gate::any(['SuperUser','Manager','OPS','Agent'], Auth::user())) {
            $orders = Order::with('cargo','user','agent')->where('status_id',2)->paginate(10);
            $title = 'In processing';
            return view('backend.shipments.index',compact('orders','title'));
        }
        return  abort(403);
    }

    public function in_work(){
        if (Gate::any(['SuperUser','Manager','OPS','Agent','Driver'], Auth::user())) {
            $orders = Order::with('cargo','user','agent','driver')->where('status_id',3)->paginate(10);
            $title = 'Accepted in work';
            return view('backend.shipments.index',compact('orders','title'));
         }
        return  abort(403);
    }
    public function delivered(){
        if (Gate::any(['SuperUser','Manager','OPS','Agent'], Auth::user())) {
           $orders = Order::with('cargo','user','agent')->where('status_id',4)->paginate(10);
           $title = 'Delivered';
           return view('backend.shipments.index',compact('orders','title'));
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
