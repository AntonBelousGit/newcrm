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

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with('cargo','user')->paginate(10);
//        dd($orders);
        return view('backend.shipments.index',compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   $user = User::all();
        return view('backend.shipments.create',compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//       dd($request->Package);
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
        $orders = Order::with('cargo','user','status','cargolocation')->findOrFail($id);
//        dd($orders);
        $user = User::all();
        $status = ProductStatus::all();
        $cargo_location = CargoLocation::all();
        return view('backend.shipments.edit',compact('orders','user','status','cargo_location'));
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
//       dd($request);
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

    public function remove_cargo(Request $request ){

        $cargo = Cargo::where('order_id',$request->order)->where('id',$request->cargo)->first();
        $cargo->delete();
        return true;
    }

    public function new_order(){

        $orders = Order::with('cargo','user')->where('status_id',1)->paginate(10);
        return view('backend.shipments.index',compact('orders'));
    }

    public function in_processing(){
        $orders = Order::with('cargo','user')->where('status_id',2)->paginate(10);
        return view('backend.shipments.index',compact('orders'));
    }

    public function in_work(){
        $orders = Order::with('cargo','user')->where('status_id',3)->paginate(10);
        return view('backend.shipments.index',compact('orders'));
    }
    public function delivered(){
        $orders = Order::with('cargo','user')->where('status_id',4)->paginate(10);
        return view('backend.shipments.index',compact('orders'));
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
