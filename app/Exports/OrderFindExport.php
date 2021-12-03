<?php

namespace App\Exports;

use App\Http\Controllers\Admin\ReportController;
use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Concerns\FromView;

class OrderFindExport implements FromView
{
    protected $request;

    function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {

        $start = $this->request->start;
        $end = $this->request->end;


        if ($this->request->driver_id != null && $this->request->agent_id == null && $this->request->status == null) {

            $order = Order::with('cargo', 'agent', 'tracker.cargolocation', 'tracker.user', 'tracker.agent', 'order', 'payer')->whereHas('tracker', function ($q) {
                $q->where('driver_id', $this->request->driver_id);
            })->get();
            $driver = User::find($this->request->driver_id);

            return view('backend.exports.reports', [
                'orders' => $order,
                'driver' => $driver,
            ]);
        }
        if ($this->request->agent_id != null && $this->request->driver_id == null && $this->request->status == null) {
            $order = Order::with('cargo', 'agent', 'tracker.cargolocation', 'tracker.user', 'tracker.agent', 'order', 'payer')->whereHas('tracker', function ($q) {
                $q->where('agent_id', $this->request->agent_id);
            })->get();
            $agent = User::find($this->request->agent_id);

            return view('backend.exports.reports', [
                'orders' => $order,
                'agent' => $agent,
            ]);
        }
        if (!is_null($this->request->status) && $this->request->driver_id == null && $this->request->agent_id == null) {

            if ($this->request->status == 0) {

                if(Gate::check('Administration',Auth::user())){
                    $user = User::find($this->request->user_id);
                    $payer_user = DB::table('payer_user')->where('user_id', $user->id)->get(['payer_id']);
                }
                else{
                    $payer_user = DB::table('payer_user')->where('user_id', Auth::id())->get(['payer_id']);
                }
                return view('backend.exports.reports', [
                    'orders' => Order::with('cargo', 'agent', 'tracker.cargolocation', 'tracker.user', 'tracker.agent', 'order', 'payer')->whereIn('payer_id', $payer_user->pluck('payer_id'))->get()
                ]);
            }
            if ($this->request->status == 2) {
                return view('backend.exports.reports', [
                    'orders' => Order::with('cargo', 'agent', 'tracker.cargolocation', 'tracker.user', 'tracker.agent', 'order', 'payer')->whereIn('status_id', [2, 3, 4, 5, 8])->whereBetween('delivery_time', [$start, $end])->get()
                ]);
            }
            return view('backend.exports.reports', [
                'orders' => Order::with('cargo', 'agent', 'tracker.cargolocation', 'tracker.user', 'tracker.agent', 'order', 'payer')->where('status_id', $this->request->status)->whereBetween('delivery_time', [$start, $end])->get()
            ]);
        }
        if ($this->request->driver_id != null && $this->request->agent_id != null && $this->request->status == null) {
            $driver = User::find($this->request->driver_id);
            $agent = User::find($this->request->agent_id);
            $order = Order::with('cargo', 'agent', 'tracker.cargolocation', 'tracker.user', 'tracker.agent', 'order', 'payer')->whereHas('tracker', function ($q) {
                $q->where('driver_id', $this->request->driver_id);
            })->whereHas('tracker', function ($q) {
                $q->where('agent_id', $this->request->agent_id);
            })->get();

            return view('backend.exports.reports', [
                'orders' => $order,
                'driver' => $driver,
                'agent' => $agent,
            ]);
        }
        if ($this->request->driver_id != null && !is_null($this->request->status) && $this->request->agent_id == null) {
            $driver = User::find($this->request->driver_id);

            if ($this->request->status == 0) {
                if(Gate::check('Administration',Auth::user())){
                    $user = User::find($this->request->user_id);
                    $payer_user = DB::table('payer_user')->where('user_id', $user->id)->get(['payer_id']);
                }
                else{
                    $payer_user = DB::table('payer_user')->where('user_id', Auth::id())->get(['payer_id']);
                }
                return view('backend.exports.reports', [
                    'orders' => Order::with('cargo', 'agent', 'tracker.cargolocation', 'tracker.user', 'tracker.agent', 'order', 'payer')->whereIn('payer_id', $payer_user->pluck('payer_id'))->whereHas('tracker', function ($q) {
                        $q->where('driver_id', $this->request->driver_id);
                    })->get(),
                    'driver' => $driver
                ]);
            }
            if ($this->request->status == 2) {
                return view('backend.exports.reports', [
                    'orders' => Order::with('cargo', 'agent', 'tracker.cargolocation', 'tracker.user', 'tracker.agent', 'order', 'payer')->whereIn('status_id', [2, 3, 4, 5, 8])->whereBetween('delivery_time', [$start, $end])->whereHas('tracker', function ($q) {
                        $q->where('driver_id', $this->request->driver_id);
                    })->get(),
                    'driver' => $driver
                ]);
            }
            return view('backend.exports.reports', [
                'orders' => Order::with('cargo', 'agent', 'tracker.cargolocation', 'tracker.user', 'tracker.agent', 'order', 'payer')->where('status_id', $this->request->status)->whereBetween('delivery_time', [$start, $end])->whereHas('tracker', function ($q) {
                    $q->where('driver_id', $this->request->driver_id);
                })->get(),
                'driver' => $driver
            ]);
        }
        if ($this->request->agent_id != null && !is_null($this->request->status) && $this->request->driver_id == null) {
            $agent = User::find($this->request->agent_id);
            if ($this->request->status == 0) {
                if(Gate::check('Administration',Auth::user())){
                    $user = User::find($this->request->user_id);
                    $payer_user = DB::table('payer_user')->where('user_id', $user->id)->get(['payer_id']);
                }
                else{
                    $payer_user = DB::table('payer_user')->where('user_id', Auth::id())->get(['payer_id']);
                }
                return view('backend.exports.reports', [
                    'orders' => Order::with('cargo', 'agent', 'tracker.cargolocation', 'tracker.user', 'tracker.agent', 'order', 'payer')->whereIn('payer_id', $payer_user->pluck('payer_id'))->whereHas('tracker', function ($q) {
                        $q->where('agent_id', $this->request->agent_id);
                    })->get(),
                    'agent' => $agent
                ]);
            }
            if ($this->request->status == 2) {
                return view('backend.exports.reports', [
                    'orders' => Order::with('cargo', 'agent', 'tracker.cargolocation', 'tracker.user', 'tracker.agent', 'order', 'payer')->whereIn('status_id', [2, 3, 4, 5, 8])->whereBetween('delivery_time', [$start, $end])->whereHas('tracker', function ($q) {
                        $q->where('agent_id', $this->request->agent_id);
                    })->get(),
                    'agent' => $agent
                ]);
            }
            return view('backend.exports.reports', [
                'orders' => Order::with('cargo', 'agent', 'tracker.cargolocation', 'tracker.user', 'tracker.agent', 'order', 'payer')->where('status_id', $this->request->status)->whereBetween('delivery_time', [$start, $end])->whereHas('tracker', function ($q) {
                    $q->where('agent_id', $this->request->agent_id);
                })->get(),
                'agent' => $agent
            ]);
        }
        if ($this->request->driver_id != null && $this->request->agent_id != null && !is_null($this->request->status)) {
            $driver = User::find($this->request->driver_id);
            $agent = User::find($this->request->agent_id);

            if ($this->request->status == 0) {
                if(Gate::check('Administration',Auth::user())){
                    $user = User::find($this->request->user_id);
                    $payer_user = DB::table('payer_user')->where('user_id', $user->id)->get(['payer_id']);
                }
                else{
                    $payer_user = DB::table('payer_user')->where('user_id', Auth::id())->get(['payer_id']);
                }
                return view('backend.exports.reports', [
                    'orders' => Order::with('cargo', 'agent', 'tracker.cargolocation', 'tracker.user', 'tracker.agent', 'order', 'payer')->whereIn('payer_id', $payer_user->pluck('payer_id'))->whereHas('tracker', function ($q) {
                        $q->where('driver_id', $this->request->driver_id);
                    })->whereHas('tracker', function ($q) {
                        $q->where('agent_id', $this->request->agent_id);
                    })->get(),
                    'driver' => $driver,
                    'agent' => $agent,
                ]);
            }
            if ($this->request->status == 2) {
                return view('backend.exports.reports', [
                    'orders' => Order::with('cargo', 'agent', 'tracker.cargolocation', 'tracker.user', 'tracker.agent', 'order', 'payer')->whereIn('status_id', [2, 3, 4, 5, 8])->whereBetween('delivery_time', [$start, $end])->whereHas('tracker', function ($q) {
                        $q->where('driver_id', $this->request->driver_id);
                    })->whereHas('tracker', function ($q) {
                        $q->where('agent_id', $this->request->agent_id);
                    })->get(),
                    'driver' => $driver,
                    'agent' => $agent,
                ]);
            }
            return view('backend.exports.reports', [
                'orders' => Order::with('cargo', 'agent', 'tracker.cargolocation', 'tracker.user', 'tracker.agent', 'order', 'payer')->where('status_id', $this->request->status)->whereBetween('delivery_time', [$start, $end])->whereHas('tracker', function ($q) {
                    $q->where('driver_id', $this->request->driver_id);
                })->whereHas('tracker', function ($q) {
                    $q->where('agent_id', $this->request->agent_id);
                })->get(),
                'driver' => $driver,
                'agent' => $agent,
            ]);
        }

        return view('backend.exports.reports', [
            'orders' => Order::with('cargo', 'agent', 'tracker.cargolocation', 'tracker.user', 'tracker.agent', 'order', 'payer')->where('status_id', $this->request->status)->whereBetween('delivery_time', [$start, $end])->get()
        ]);

    }
}
