<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdditionOrderInfo;
use App\Models\AddressesList;
use App\Models\Cargo;
use App\Models\CargoLocation;
use App\Models\Order;
use App\Models\Payer;
use App\Models\ProductStatus;
use App\Models\SubProductStatus;
use App\Models\Tracker;
use App\Models\User;
use App\Services\PackageServices;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use App\Services\OrderService;
use App\Services\TrackerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use JetBrains\PhpStorm\NoReturn;
use Spatie\Activitylog\Models\Activity;

class OrderController extends Controller
{

    protected $orderService;
    protected $trakerService;
    protected $packageServices;

    public function __construct(OrderService $orderService, TrackerService $trackerService, PackageServices $packageServices)
    {
        $this->orderService = $orderService;
        $this->trakerService = $trackerService;
        $this->packageServices = $packageServices;
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
            $statuses = ProductStatus::all();
            $title = 'All Shipments';
            return view('backend.shipments.index', compact('orders','title','statuses'));
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
            $addresses = Gate::check('Client', Auth::user()) ? AddressesList::where('user_id', Auth::id())->get(['address']) : AddressesList::all(['address']);
            $cargo_location = CargoLocation::all();
            return view('backend.shipments.create', compact('user', 'cargo_location', 'payers', 'addresses'));
        }
        return abort(403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (Gate::any(['SuperUser', 'Manager', 'OPS', 'Client'], Auth::user())) {

            $order = $this->orderService->saveOrder($request);


            if ($request->shipper_address_id) {
                $start_tracker = new Tracker;
                $start_tracker->order_id = $order->id;
                $start_tracker->location_id = $request->shipper_address_id;
                $start_tracker->address = $request->address_shipper;
                $start_tracker->start_time = $request->sending_time;
                $start_tracker->start_time_stop = $request->sending_time_stop;
                $start_tracker->post_code = $request->shipper_postcode;
                $start_tracker->position = '0';
                $start_tracker->save();
            }
            if ($request->consignee_address_id) {
                $start_tracker = new Tracker;
                $start_tracker->order_id = $order->id;
                $start_tracker->location_id = $request->consignee_address_id;
                $start_tracker->address = $request->address_consignee;
                $start_tracker->start_time = $request->delivery_time;
                $start_tracker->start_time_stop = $request->delivery_time_stop;
                $start_tracker->post_code = $request->consignee_postcode;

                $start_tracker->position = '2';
                $start_tracker->save();
            }

            $this->orderService->createCargo($request, $order);

            if ($order->return_sensor == 'on' || $order->return_container == 'on') {
                $this->returned_order($request, $order->id);
            }

            if (Gate::any(['SuperUser', 'Manager', 'OPS'], Auth::user())) {
                return redirect()->route('admin.orders.index');
            }
            if (Gate::any(['Client'], Auth::user())) {
                return redirect()->action(
                    [OrderController::class, 'show'], ['order' => $order->id]
                );

            }

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
        if (Gate::any(['SuperUser', 'Manager', 'OPS'], Auth::user())) {

            $order = $this->orderService->saveReturnedOrder($request, $request->parent_id, true);

            if ($request->shipper_address_id) {
                $start_tracker = new Tracker;
                $start_tracker->order_id = $order->id;
                $start_tracker->location_id = $request->shipper_address_id;
                $start_tracker->address = $request->address_shipper;
                $start_tracker->post_code = $request->shipper_postcode;
                $start_tracker->start_time = $request->sending_time;
                $start_tracker->start_time_stop = $request->sending_time_stop;
                $start_tracker->position = '0';
                $start_tracker->save();
            }
            if ($request->consignee_address_id) {
                $start_tracker = new Tracker;
                $start_tracker->order_id = $order->id;
                $start_tracker->location_id = $request->consignee_address_id;
                $start_tracker->address = $request->address_consignee;
                $start_tracker->post_code = $request->consignee_postcode;
                $start_tracker->start_time = $request->delivery_time;
                $start_tracker->start_time_stop = $request->delivery_time_stop;
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

        $order = $this->orderService->saveReturnedOrder($request, $id, false);

        if ($request->shipper_address_id) {
            $start_tracker = new Tracker;
            $start_tracker->order_id = $order->id;
            $start_tracker->location_id = $request->shipper_address_id;
            $start_tracker->address = $request->address_shipper;
            $start_tracker->post_code = $request->shipper_postcode;

//            $start_tracker->start_time = $request->sending_time;
            $start_tracker->position = '2';
            $start_tracker->save();
        }
        if ($request->consignee_address_id) {
            $start_tracker = new Tracker;
            $start_tracker->order_id = $order->id;
            $start_tracker->location_id = $request->consignee_address_id;
            $start_tracker->address = $request->address_consignee;
            $start_tracker->post_code = $request->consignee_postcode;
            $start_tracker->start_time = null;
            $start_tracker->start_time_stop = null;
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
        $tracker_start = Tracker::with('cargolocation')->where('order_id', $id)->where('position', '0')->first();
        $tracker_end = Tracker::with('cargolocation')->where('order_id', $id)->where('position', '2')->first();
        $orders = Order::with('cargo', 'user', 'status', 'cargolocation', 'agent', 'driver', 'payer')->findOrFail($id);
        $addInfo = AdditionOrderInfo::where('order_id',$id)->first();
        $logs = Activity::with('user')->where('order_id', $id)
            ->orWhere(function ($query) use ($id) {
                $query->where('log_name', 'Order')
                    ->where('subject_id', $id);
            })->orderBy('created_at', 'DESC')->get();

        return view('backend.shipments.show', compact('orders', 'tracker_start', 'tracker_end', 'logs','addInfo'));
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

            $status = ProductStatus::all();
            $payers = Payer::all();
            $substatus = SubProductStatus::all();
            $cargo_location = CargoLocation::all();
            $addInfo = AdditionOrderInfo::where('order_id',$id)->first();
            $addresses = Gate::check('Client', Auth::user()) ? AddressesList::where('user_id', Auth::id())->get(['address']) : AddressesList::all(['address']);

            return view('backend.shipments.edit', compact('orders', 'user', 'status', 'cargo_location', 'trackers', 'tracker_start', 'tracker_end', 'substatus', 'lupa', 'trackers_count', 'payers','addresses','addInfo'));
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
        if (Gate::any(['SuperUser', 'Manager', 'OPS'], Auth::user())) {

            $order = $this->orderService->findAndUpdate($request, $id);

            if (isset($request->Package)) {
                foreach ($request->Package as $option_key) {
                    if ($option_key['id']) {
                        $cargo = Cargo::findOrFail($option_key['id']);
                        $cargo->type = $option_key['type'];
                        $cargo->quantity = $option_key['quantity'];
                        $cargo->serial_number = $option_key['serial_number'];
                        $cargo->serial_number_sensor = $option_key['serial_number_sensor'];
                        $cargo->un_number = $option_key['un_number'];
                        $cargo->actual_weight = $option_key['actual_weight'];
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
//            dd(count($request->time));
            if (!isset($request->time)) {

                $this->trakerService->updateStartTracker($order, $request, false);
                $this->trakerService->updateEndTracker($order, $request);

            } elseif (count($request->time) == 1) {

                $this->trakerService->updateStartTracker($order, $request, true);
                foreach ($request->time as $option_key) {

                    if (!isset($option_key['id'])) {
                        $this->trakerService->createTransitionalTracker($order, $option_key, false);
                    } else if (isset($option_key['id'])) {

                        $this->trakerService->updateTransitionalTracker($order, $option_key, false);
                    }
                }
                $this->trakerService->updateEndTracker($order, $request);
            } elseif (count($request->time) > 1) {
                $this->trakerService->updateStartTracker($order, $request, true);

                foreach ($request->time as $option_key) {
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
                $tracker_start->post_code = $request->shipper_postcode;

//                $tracker_start->start_time = $request->sending_time;
                $tracker_start->update();
            }
            if ($request->consignee_address_id) {
                $tracker_end = Tracker::with('cargolocation')->where('order_id', $order->id)->where('position', '2')->first();
                $tracker_end->location_id = $request->consignee_address_id;
                $tracker_end->address = $request->address_consignee;
                $tracker_end->post_code = $request->consignee_postcode;

//                $tracker_end->start_time = $request->delivery_time;
                $tracker_end->update();
            }

            if ($request->submitted === "Save") {
                return redirect()->back();
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
            $statuses = ProductStatus::all();

            return view('backend.shipments.index', compact('orders', 'title','statuses'));
        }
        return abort(403);
    }

    public function in_work()
    {
        $statuses = ProductStatus::all();
        if (Gate::any(['SuperUser', 'Manager', 'OPS'], Auth::user())) {
            $orders = Order::with('cargo', 'user', 'agent', 'driver','tracker.cargolocation')->whereIn('status_id', [2, 3, 4, 5, 8])->get();
            $title = 'Accepted in work';
            return view('backend.shipments.index-in-work', compact('orders', 'title','statuses'));
        }
        if (Gate::any(['Agent', 'Driver'], Auth::user())) {
            $orders = Order::with('cargo', 'user', 'agent', 'driver','tracker.cargolocation')->whereIn('status_id', [2, 3, 4, 5, 8])->get();
            $title = 'Accepted in work';
            return view('backend.shipments.index-in-work', compact('orders', 'title','statuses'));
        }
        return abort(403);
    }

    public function delivered()
    {
        if (Gate::any(['SuperUser', 'Manager', 'OPS', 'Agent'], Auth::user())) {
            $orders = Order::with('cargo', 'user', 'agent', 'status','tracker.cargolocation')->where('status_id', 6)->get();
            $statuses = ProductStatus::all();
            $title = 'Delivered';
            return view('backend.shipments.index-delivered', compact('orders', 'title','statuses'));
        }
        return abort(403);
    }

    public function archives()
    {
        if (Gate::any(['SuperUser', 'Manager', 'OPS', 'Client'], Auth::user())) {
            $orders = Order::with('cargo', 'user', 'agent', 'status')->where('status_id', 9)->get();
            $title = 'Archives';
            return view('backend.shipments.index-one-status', compact('orders', 'title'));
        }
        return abort(403);
    }

    public function return_job()
    {
        if (Gate::any(['SuperUser', 'Manager', 'OPS', 'Client'], Auth::user())) {
            $orders = Order::with('cargo', 'user', 'agent', 'status','tracker.cargolocation')->where('returned', 1)->get();
            $title = 'Return Job';
            $statuses = ProductStatus::all();
            return view('backend.shipments.index-one-status', compact('orders', 'title','statuses'));
        }
        return abort(403);
    }
    public function canceled()
    {
        if (Gate::any(['SuperUser', 'Manager', 'OPS'], Auth::user())) {
            $orders = Order::with('cargo', 'user', 'agent', 'status')->where('status_id', 10)->get();
            $title = 'Canceled';
            return view('backend.shipments.index-one-status', compact('orders', 'title'));
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

            return redirect()->back();

        }
        return abort(403);
    }

    public function duplicate(int $id)
    {
        $order = Order::where('id', $id)->first();
        $addInfo = AdditionOrderInfo::where('order_id',$id)->first();
        if (Gate::any(['Administration', 'manage-user-order'], $order)) {
            $new_order = $this->orderService->duplicate($order,$addInfo);
            $this->packageServices->duplicate($new_order, $order);
            $this->trakerService->duplicate($new_order, $order);
        }
        return redirect()->route('admin.orders.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Gate::check('Administration',Auth::id())){
            $order = Order::find($id);
            if ($order) {
                $order->status_id = 10 ;
                $status = $order->update();
                if ($status) {
                    return redirect()->route('admin.orders.index')->with('success', 'Successfully canceled order');
                }
                return back()->with('error', 'Something went wrong!');
            }
            return back()->with('error', 'Data not found');
        }
        abort(403);
    }
}
