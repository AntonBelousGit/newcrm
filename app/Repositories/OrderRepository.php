<?php

namespace App\Repositories;

use App\Models\AdditionOrderInfo;
use App\Models\AddressesList;
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
        return $this->order->with('cargo', 'user', 'tracker.cargolocation', 'order')->whereNotIn('status_id', [9,10])->get();
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
        $order->email = $request->email ?? '';

        if (!is_null($request->sending_time)) {
            $order->sending_time = str_replace('T', ' ', $request->sending_time);
        }
        if (!is_null($request->delivery_time_stop)) {
            $order->delivery_time = str_replace('T', ' ', $request->delivery_time_stop);
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
        $this->AddOrderInfo($request, $order->id);

        $order->update();

        if (isset($request->address_shipper_checkbox)) {
            $this->saveAddress($request->address_shipper);
        }
        if (isset($request->address_consignee_checkbox)) {
            $this->saveAddress($request->address_consignee);
        }

        return $order;
    }

    public function AddOrderInfo($request, $id)
    {
        $addInfo = new AdditionOrderInfo;
        $addInfo->order_id = $id;
        $addInfo->direct_to_person_shipper = $request->direct_to_person_shipper ?? 'off';
        $addInfo->direct_to_person_consignee = $request->direct_to_person_consignee ?? 'off';
        $addInfo->additional_shipper_contact = $request->additional_shipper_contact;
        $addInfo->additional_consignee_contact = $request->additional_consignee_contact;
        $addInfo->save();
    }

    public function findAddOrderInfo($order_id)
    {
        return AdditionOrderInfo::where('order_id',$order_id)->first();
    }


    public function updateAddOrderInfo($request, $id)
    {
        $addInfo = $this->findAddOrderInfo($id);

        $addInfo->direct_to_person_shipper = $request->direct_to_person_shipper ?? 'off';
        $addInfo->direct_to_person_consignee = $request->direct_to_person_consignee ?? 'off';
        $addInfo->additional_shipper_contact = $request->additional_shipper_contact;
        $addInfo->additional_consignee_contact = $request->additional_consignee_contact;
        $addInfo->update();
    }
    public function saveReturnedOrder($request, $id, $email)
    {
//        dd($request);
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

        if ($email) {
            $order->notifications = $request->notifications ?? 'off';
            $order->email = $request->email ?? '';
        } else {
            $order->notifications = 'off';
        }
        $order->status_id = 1;
        $order->cargo_location_id = 1;
        if (Gate::any(['Client'], Auth::user())) {
            $order->client_id = Auth::id();
        }
        if (isset($request->client_id)) {
            $order->client_id = $request->client_id;
        }
        $order->save();
        $order->invoice_number = $order->id;
        $this->AddOrderInfo($request, $order->id);
        $order->update();

        return $order;
    }

    public function saveAddress($address)
    {
        $new_address = new AddressesList;
        $new_address->address = $address;
        $new_address->user_id = Auth::id();
        $new_address->save();
        return true;
    }

    public function findAndUpdate($request, $id)
    {
        $order = $this->findById($id);
//        dd($request);
        if (!in_array($order->status_id, [6, 7, 9, 10]) && !in_array($request->status_id, [6, 7, 9, 10])) {
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
            $order->client_hwb = $request->client_hwb ?? null;
            $order->locations = $request->locations;
            $order->locations_id = $request->city_id;

            if (!is_null($request->start['start_time'])) {
                $order->sending_time = str_replace('T', ' ', $request->start['start_time']);
            }
            if (!is_null($request->end['start_time_stop'])) {
                $order->delivery_time = str_replace('T', ' ', $request->end['start_time_stop']);
            }

//            $order->delivery_time = $request->delivery_time;
            $order->delivery_comment = $request->delivery_comment;
            $order->payer_id = $request->payer_id;
//            if ($order->status_id < 2 && $request->status_id < 3) {
            $order->my_sensor = $request->my_sensor ?? 'off';
            $order->my_container = $request->my_container ?? 'off';
            $order->sensor_for_rent = $request->sensor_for_rent ?? 'off';
            $order->container = $request->container ?? 'off';
            $order->notifications = $request->notifications ?? 'off';
            $order->email = $request->email ?? '';
            $order->status_id = $request->status_id;

            if (!is_null($request->substatus_id)) {
                $order->substatus_id = $request->substatus_id;
            }
            $order->cargo_location_id = $request->cargo_location_id ?? 1;

            $this->updateAddOrderInfo($request,$order->id);

            $order->update();
        }
        return $order;
    }

    public function findById($id)
    {
        return Order::with('cargo')->findOrFail($id);
    }

    public function createCargo($request, $order)
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

    public function duplicate($order,$addInfo)
    {
        $new_order = $order->replicate();
        $new_order->created_at = now();
        $new_order->invoice_number = null;
        $new_order->status_id = 1;
        $new_order->save();
        $new_order->invoice_number = $new_order->id;
        $new_info = $addInfo->replicate();
        $new_info->order_id = $new_order->id;
        $new_info->save();
        $new_order->update();
        return $new_order;
    }
}
