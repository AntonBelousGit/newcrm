<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cargo;
use App\Models\Order;
use App\Models\User;
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
        $order->user_id = $request->user_id;

        $order->sensor_for_rent = $request->sensor_for_rent ?? 'off';
        $order->container = $request->container ?? 'off';
        $order->return_sensor = $request->return_sensor ?? 'off';
        $order->return_container = $request->return_container ?? 'off';
        $order->notifications = $request->notifications ?? 'off';

        $order->save();

//        $order->user()->attach($request->user_id);
        foreach ($request->Package as $item){
//            dd($request->Package);
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
        $orders = Order::with('cargo','user')->findOrFail($id);
        $user = User::all();
        return view('backend.shipments.edit',compact('orders','user'));
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
        //
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
