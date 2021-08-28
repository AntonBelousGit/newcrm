<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cargo;
use App\Models\CargoLocation;
use App\Models\Order;
use App\Models\Payer;
use App\Models\ProductStatus;
use App\Models\SubProductStatus;
use App\Models\Tracker;
use App\Models\User;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use App\Services\OrderService;
use App\Services\TrackerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{

    protected $orderService;
    protected $trakerService;

    public function __construct(OrderService $orderService, TrackerService $trackerService)
    {
        $this->orderService = $orderService;
        $this->trakerService = $trackerService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::any(['SuperUser', 'Manager', 'OPS', 'Agent', 'Driver', 'Client'], Auth::user())) {
            $orders = $this->orderService->getAll();

//            dd($orders);
            $title = 'All Shipments';
            return view('backend.shipments.index', compact('orders', 'title'));
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
        if (Gate::any(['SuperUser', 'Manager', 'OPS', 'Client'], Auth::user())) {
            $user = User::all();
            $payers = Payer::all();
            $cargo_location = CargoLocation::all();
            return view('backend.shipments.create', compact('user', 'cargo_location', 'payers'));
        }
        return abort(403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::any(['SuperUser', 'Manager', 'OPS', 'Client'], Auth::user())) {
//            dd($request);

            $order = $this->orderService->saveOrder($request);


            if ($request->shipper_address_id) {
                $start_tracker = new Tracker;
                $start_tracker->order_id = $order->id;
                $start_tracker->location_id = $request->shipper_address_id;
                $start_tracker->address = $request->address_shipper;
                $start_tracker->start_time = $request->sending_time;
                $start_tracker->position = '0';
                $start_tracker->save();
            }
            if ($request->consignee_address_id) {
                $start_tracker = new Tracker;
                $start_tracker->order_id = $order->id;
                $start_tracker->location_id = $request->consignee_address_id;
                $start_tracker->address = $request->address_consignee;
                $start_tracker->start_time = $request->delivery_time;
                $start_tracker->position = '2';
                $start_tracker->save();
            }

            $this->orderService->createCargo($request, $order);

            if ($order->return_sensor == 'on' || $order->return_container == 'on') {
                $this->returned_order($request, $order->id);
            }


            return redirect()->route('admin.orders.index');
        }
        return abort(403);
    }

    public function create_returned_order()
    {
        if (Gate::any(['SuperUser', 'Manager', 'OPS'], Auth::user())) {
            $users = User::whereHas('roles', function ($q) {
                $q->where('name', 'Client');
            })->get();
            $parentOrder = $this->orderService->getAllParentOrder();
            $payers = Payer::all();
            $cargo_location = CargoLocation::all();
            return view('backend.shipments.create-return', compact('users', 'cargo_location', 'payers', 'parentOrder'));
        }
        return abort(403);
    }

    public function store_returned_order(Request $request)
    {
//        dd($request);
        if (Gate::any(['SuperUser', 'Manager', 'OPS'], Auth::user())) {

            $order = $this->orderService->saveReturnedOrder($request, $request->parent_id);

            if ($request->shipper_address_id) {
                $start_tracker = new Tracker;
                $start_tracker->order_id = $order->id;
                $start_tracker->location_id = $request->shipper_address_id;
                $start_tracker->address = $request->address_shipper;
                $start_tracker->start_time = $request->sending_time;
                $start_tracker->position = '0';
                $start_tracker->save();
            }
            if ($request->consignee_address_id) {
                $start_tracker = new Tracker;
                $start_tracker->order_id = $order->id;
                $start_tracker->location_id = $request->consignee_address_id;
                $start_tracker->address = $request->address_consignee;
                $start_tracker->start_time = $request->delivery_time;
                $start_tracker->position = '2';
                $start_tracker->save();
            }

            $this->orderService->createCargo($request, $order);


            return redirect()->route('admin.orders.index');
        }
        return abort(403);
    }

    //Автоматически создаваемая обратная заявка
    public function returned_order($request, $id)
    {

        $order = $this->orderService->saveReturnedOrder($request, $id);

        if ($request->shipper_address_id) {
            $start_tracker = new Tracker;
            $start_tracker->order_id = $order->id;
            $start_tracker->location_id = $request->shipper_address_id;
            $start_tracker->address = $request->address_shipper;
//            $start_tracker->start_time = $request->sending_time;
            $start_tracker->position = '2';
            $start_tracker->save();
        }
        if ($request->consignee_address_id) {
            $start_tracker = new Tracker;
            $start_tracker->order_id = $order->id;
            $start_tracker->location_id = $request->consignee_address_id;
            $start_tracker->address = $request->address_consignee;
            $start_tracker->start_time = $request->delivery_time;
            $start_tracker->position = '0';
            $start_tracker->save();
        }

        $this->orderService->createCargo($request, $order);

        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $orders = Order::with('cargo', 'user', 'status', 'cargolocation', 'agent', 'driver')->findOrFail($id);
        return view('backend.shipments.show', compact('orders'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::any(['SuperUser', 'Manager', 'OPS'], Auth::user())) {
            $orders = Order::with('cargo', 'user', 'status', 'cargolocation', 'tracker')->find($id);
            $user = User::all();

            $tracker_start = Tracker::with('cargolocation')->where('order_id', $id)->where('position', '0')->first();
            $trackers = Tracker::with('cargolocation')->where('order_id', $id)->where('position', '1')->get();
            $trackers_count = count($trackers);

            $lupa[] = $tracker_start->cargolocation->toArray();

            foreach ($trackers as $item) {
                $lupa[] = $item->cargolocation->toArray();
            }
            $tracker_end = Tracker::with('cargolocation')->where('order_id', $id)->where('position', '2')->first();

            $lupa[] = $tracker_end->cargolocation->toArray();

//            dd($trackers_count);

            $status = ProductStatus::all();
            $payers = Payer::all();
            $substatus = SubProductStatus::all();
            $cargo_location = CargoLocation::all();

            return view('backend.shipments.edit', compact('orders', 'user', 'status', 'cargo_location', 'trackers', 'tracker_start', 'tracker_end', 'substatus', 'lupa', 'trackers_count', 'payers'));
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
//        dd($request);
        if (Gate::any(['SuperUser', 'Manager', 'OPS'], Auth::user())) {

            $order = $this->orderService->findAndUpdate($request, $id);


            if (isset($request->Package)) {
                foreach ($request->Package as $option_key) {
//                    dd($request->Package);
                    if ($option_key['id']) {
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
                        $cargo->volume_weight = ($option_key['сargo_dimensions_height'] * $option_key['сargo_dimensions_width'] * $option_key['сargo_dimensions_length']) / 6000;
                        $cargo->update();
                    } else {
                        $cargo = new Cargo();
                        $cargo->order_id = $order->id;
                        $cargo->type = $option_key['type'];
                        $cargo->actual_weight = $option_key['actual_weight'];
                        $cargo->quantity = $option_key['quantity'];
                        $cargo->serial_number = $option_key['serial_number'] ?? null;
                        $cargo->serial_number_sensor = $option_key['serial_number_sensor'] ?? null;
                        $cargo->un_number = $option_key['un_number'] ?? null;
                        $cargo->temperature_conditions = $option_key['temperature_conditions'];
                        $cargo->сargo_dimensions_length = $option_key['сargo_dimensions_length'];
                        $cargo->сargo_dimensions_width = $option_key['сargo_dimensions_width'];
                        $cargo->сargo_dimensions_height = $option_key['сargo_dimensions_height'];
                        $cargo->volume_weight = ($option_key['сargo_dimensions_height'] * $option_key['сargo_dimensions_width'] * $option_key['сargo_dimensions_length']) / 6000;
                        $cargo->save();
                    }
                }
            }


//            dd(isset($request->time));

            if (!isset($request->time)) {

                $this->trakerService->updateStartTracker($order, $request, false);
                $this->trakerService->updateEndTracker($order, $request);

            } elseif (count($request->time) == 1) {


                $this->trakerService->updateStartTracker($order, $request, true);
                foreach ($request->time as $option_key) {

                    if (!isset($option_key['id'])) {
                        $this->trakerService->createTransitionalTracker($order, $option_key, false);
                    } else if (isset($option_key['id'])) {
//                        dd($option_key['id']);

                        $this->trakerService->updateTransitionalTracker($order, $option_key, false);
                    }
                }
                $this->trakerService->updateEndTracker($order, $request);
            } elseif (count($request->time) > 1) {
                $this->trakerService->updateStartTracker($order, $request, true);

                foreach ($request->time as $option_key) {
//                    dd(count($request->time));
                    if (!isset($option_key['id'])) {
                        $this->trakerService->createTransitionalTracker($order, $option_key, true);
                    } else if (isset($option_key['id'])) {
                        $this->trakerService->updateTransitionalTracker($order, $option_key, true);
                    }
                }
                $this->trakerService->updateEndTracker($order, $request);
            }


            if ($request->shipper_address_id) {
                $tracker_start = Tracker::with('cargolocation')->where('order_id', $order->id)->where('position', '0')->first();
                $tracker_start->location_id = $request->shipper_address_id;
                $tracker_start->address = $request->address_shipper;
//                $tracker_start->start_time = $request->sending_time;
                $tracker_start->update();
            }
            if ($request->consignee_address_id) {
                $tracker_end = Tracker::with('cargolocation')->where('order_id', $order->id)->where('position', '2')->first();
                $tracker_end->location_id = $request->consignee_address_id;
                $tracker_end->address = $request->address_consignee;
//                $tracker_end->start_time = $request->delivery_time;
                $tracker_end->update();
            }

            return redirect()->route('admin.orders.index');
        }
        return abort(403);
    }

    public function remove_cargo(Request $request)
    {
        if (Gate::any(['SuperUser', 'Manager', 'OPS'], Auth::user())) {
            $cargo = Cargo::where('order_id', $request->order)->where('id', $request->cargo)->first();
            if (is_null($cargo)) {
                return true;
            }
            $cargo->delete();
            return true;
        }
        return abort(403);
    }

    public function new_order()
    {

        if (Gate::any(['SuperUser', 'Manager', 'OPS', 'Agent'], Auth::user())) {
            $orders = Order::with('cargo', 'user', 'agent', 'driver')->where('status_id', 1)->get();
            $title = 'New order';
            return view('backend.shipments.index', compact('orders', 'title'));
        }
        return abort(403);
    }

    public function in_work()
    {
        if (Gate::any(['SuperUser', 'Manager', 'OPS'], Auth::user())) {
            $orders = Order::with('cargo', 'user', 'agent', 'driver')->where('status_id', 2)->get();
            $title = 'Accepted in work';
            return view('backend.shipments.index-in-work', compact('orders', 'title'));
        }
        if (Gate::any(['Agent', 'Driver'], Auth::user())) {
            $orders = Order::with('cargo', 'user', 'agent', 'driver')->whereIn('status_id', [2, 3, 4, 5, 8])->get();
            $title = 'Accepted in work';
            return view('backend.shipments.index-in-work', compact('orders', 'title'));

        }
        return abort(403);
    }

    public function delivered()
    {
        if (Gate::any(['SuperUser', 'Manager', 'OPS', 'Agent'], Auth::user())) {
            $orders = Order::with('cargo', 'user', 'agent', 'substatus')->where('status_id', 6)->get();
            $title = 'Delivered';
            return view('backend.shipments.index-delivered', compact('orders', 'title'));
        }
        return abort(403);
    }

    public function archives()
    {
        if (Gate::any(['SuperUser', 'Manager', 'OPS'], Auth::user())) {
            $orders = Order::with('cargo', 'user', 'agent', 'substatus')->where('status_id', 9)->get();
            $title = 'Archives';
            return view('backend.shipments.index', compact('orders', 'title'));
        }
        return abort(403);
    }

    public function return_job()
    {
        if (Gate::any(['SuperUser', 'Manager', 'OPS','Client'], Auth::user())) {
            $orders = Order::with('cargo', 'user', 'agent', 'substatus')->where('returned', 1)->get();
            $title = 'Return Job';
            return view('backend.shipments.index', compact('orders', 'title'));
        }
        return abort(403);
    }

    public function edit_agent_driver($id)
    {
        if (Gate::any(['Agent', 'Driver'], Auth::user())) {
            $orders = Order::with('cargo', 'user', 'status', 'cargolocation', 'tracker')->find($id);
            $user = User::all();
            $trackers = Tracker::with('cargolocation')->where('order_id', $id)->where('position', '1')->get();
            $tracker_start = Tracker::with('cargolocation')->where('order_id', $id)->where('position', '0')->first();
            $tracker_end = Tracker::with('cargolocation')->where('order_id', $id)->where('position', '2')->first();
            $status = ProductStatus::all();
            $cargo_location = CargoLocation::all();

            return view('backend.shipments.edit-driver-agent', compact('orders', 'user', 'status', 'cargo_location', 'trackers', 'tracker_start', 'tracker_end'));
        }
        return abort(403);
    }

    public function update_agent_driver_tracker(Request $request, $id)
    {

        $order = Order::find($id);
        if (Gate::any(['manage-agent', 'manage-driver'], $order)) {
//                dd($request);

            if (!isset($request->time)) {

                $this->trakerService->updateDriverStartTracker($order, $request, false);
                $this->trakerService->updateDriverEndTracker($order, $request);

            } elseif (count($request->time) == 1) {


                $this->trakerService->updateDriverStartTracker($order, $request, true);
                foreach ($request->time as $option_key) {

                    $this->trakerService->updateDriverTransitionalTracker($order, $option_key, false);
                }
                $this->trakerService->updateDriverEndTracker($order, $request);
            } elseif (count($request->time) > 1) {
                $this->trakerService->updateDriverStartTracker($order, $request, true);

                foreach ($request->time as $option_key) {
//
                    if (isset($option_key['id'])) {
                        $this->trakerService->updateDriverTransitionalTracker($order, $option_key, true);
                    }
                }
                $this->trakerService->updateDriverEndTracker($order, $request);
            }

            return redirect()->route('admin.orders.in_work');

        }
//        dd($tracker_start);
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
