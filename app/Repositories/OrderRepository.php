<?php

namespace App\Repositories;

use App\Models\Cargo;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class OrderRepository
{

    protected $order;


    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function getAll()
    {
        return $this->order->with('cargo', 'user', 'tracker.cargolocation', 'order')->where('status_id', '!=', 9)->get();
    }
    public function getAllParentOrder()
    {
        return $this->order->where('returned', '!=', 1)->get();
    }

    public function saveOrder($request)
    {

        $order = new Order();
        $order->shipper = $request->shipper;
        $order->phone_shipper = $request->phone_shipper;
        $order->company_shipper = $request->company_shipper;
        $order->site_shipper = $request->site_shipper;
        $order->consignee = $request->consignee;
        $order->phone_consignee = $request->phone_consignee;
        $order->site_consignee = $request->site_consignee;
        $order->shipper_address_id = $request->shipper_address_id;
        $order->consignee_address_id = $request->consignee_address_id;
        $order->company_consignee = $request->company_consignee;
        $order->shipment_description = $request->shipment_description ?? null;
        $order->comment = $request->comment ?? null;

        if (!is_null($request->sending_time)) {
            $order->sending_time = str_replace('T', ' ', $request->sending_time);
        }
        if (!is_null($request->delivery_time)) {
            $order->delivery_time = str_replace('T', ' ', $request->delivery_time);
        }
        $order->delivery_comment = $request->delivery_comment;
        $order->payer_id = $request->payer_id;
        $order->my_sensor = $request->my_sensor ?? 'off';
        $order->my_container = $request->my_container ?? 'off';
        $order->sensor_for_rent = $request->sensor_for_rent ?? 'off';
        $order->container = $request->container ?? 'off';
        $order->return_sensor = $request->return_sensor ?? 'off';
        $order->return_container = $request->return_container ?? 'off';
        $order->notifications = $request->notifications ?? 'off';
        $order->status_id = 1;
        $order->cargo_location_id = 1;
        if (Gate::any(['Client'], Auth::user())) {
            $order->client_id = Auth::id();
        }

        $order->save();
        $order->invoice_number = $order->id;
        $order->update();

        return $order;
    }

    public function saveReturnedOrder($request, $id)
    {
//        dd($id);
        $order = new Order();

        $order->shipper = $request->consignee;
        $order->phone_shipper = $request->phone_consignee;
        $order->company_shipper = $request->company_consignee;
        $order->site_shipper = $request->site_consignee;
        $order->consignee = $request->shipper;
        $order->phone_consignee = $request->phone_shipper;
        $order->company_consignee = $request->company_shipper;
        $order->site_consignee = $request->site_shipper;
        $order->shipper_address_id = $request->shipper_address_id;
        $order->consignee_address_id = $request->consignee_address_id;

        $order->shipment_description = '';
        $order->comment = '';
        $order->returned = 1;
        $order->order_id = $id;
//        if (!is_null($request->sending_time)) {
//            $order->sending_time = str_replace('T', ' ', $request->sending_time);
//        }
        if (!is_null($request->delivery_time)) {
            $order->sending_time = str_replace('T', ' ', $request->delivery_time);
        }
        $order->delivery_comment = '';
        $order->payer_id = $request->payer_id;
        $order->my_sensor = $request->my_sensor ?? 'off';
        $order->my_container = $request->my_container ?? 'off';
        $order->sensor_for_rent = $request->sensor_for_rent ?? 'off';
        $order->container = $request->container ?? 'off';
        $order->return_sensor = $request->return_sensor ?? 'off';
        $order->return_container = $request->return_container ?? 'off';
        $order->notifications = $request->notifications ?? 'off';
        $order->status_id = 1;
        $order->cargo_location_id = 1;
        if (Gate::any(['Client'], Auth::user())) {
            $order->client_id = Auth::id();
        }
        if (isset($request->client_id)){
            $order->client_id = $request->client_id;
        }

        $order->save();

        $order->invoice_number = $order->id;

        $order->update();

        return $order;
    }

    public function findAndUpdate($request, $id)
    {
        $order = $this->findById($id);

        $order->shipper = $request->shipper;
        $order->phone_shipper = $request->phone_shipper;
        $order->company_shipper = $request->company_shipper;
        $order->site_shipper = $request->site_shipper;
        $order->consignee = $request->consignee;
        $order->phone_consignee = $request->phone_consignee;
        $order->company_consignee = $request->company_consignee;
        $order->site_consignee = $request->site_consignee;
        $order->shipment_description = $request->shipment_description ?? null;
        $order->comment = $request->comment ?? null;
        $order->locations = $request->locations;
        $order->locations_id = $request->city_id;

        if (!is_null($request->sending_time)) {
            $order->sending_time = str_replace('T', ' ', $request->sending_time);
        }

//        $order->delivery_time = $request->delivery_time;
        $order->delivery_comment = $request->delivery_comment;
        $order->payer_id = $request->payer_id;
        $order->my_sensor = $request->my_sensor ?? 'off';
        $order->my_container = $request->my_container ?? 'off';
        $order->sensor_for_rent = $request->sensor_for_rent ?? 'off';
        $order->container = $request->container ?? 'off';
        $order->notifications = $request->notifications ?? 'off';
        $order->status_id = $request->status_id;
        $order->agent_id = $request->agent_id ?? null;
        if (!is_null($request->substatus_id)) {
            $order->substatus_id = $request->substatus_id;
        }
        $order->cargo_location_id = $request->cargo_location_id ?? 1;

        $order->update();

        return $order;
    }

    public function findById($id)
    {
        return Order::with('cargo')->findOrFail($id);
    }

    public function createCargo($request,$order)
    {
        foreach ($request->Package as $item) {

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
            $cargo->volume_weight = ($item['сargo_dimensions_height'] * $item['сargo_dimensions_width'] * $item['сargo_dimensions_length']) / 6000;
            $cargo->save();
        }

        return true;
    }

}
