<?php

namespace App\Exports;

use App\Http\Controllers\Admin\ReportController;
use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class OrderExport implements FromView
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

        if ($this->request->driver != 'null' && $this->request->agent == 'null' && $this->request->status == 'null') {

            $order = Order::with('cargo', 'agent', 'tracker.cargolocation', 'tracker.user', 'tracker.agent', 'order', 'payer')->whereHas('tracker', function ($q) {
                $q->where('driver_id', $this->request->driver);
            })->get();
            $driver = User::find($this->request->driver);

            return view('backend.exports.reports', [
                'orders' => $order,
                'driver' => $driver,
            ]);
        }
        if ($this->request->agent != 'null' && $this->request->driver == 'null' && $this->request->status == 'null') {

            $order = Order::with('cargo', 'agent', 'tracker.cargolocation', 'tracker.user', 'tracker.agent', 'order', 'payer')->whereHas('tracker', function ($q) {
                $q->where('agent_id', $this->request->agent);
            })->get();
            $agent = User::find($this->request->agent);

            return view('backend.exports.reports', [
                'orders' => $order,
                'agent' => $agent,
            ]);
        }
        if ($this->request->status != 'null' && $this->request->driver == 'null' && $this->request->agent == 'null') {
            if ($this->request->status == 0) {
                $payer_user = DB::table('payer_user')->where('user_id', Auth::id())->get(['payer_id']);
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
        if ($this->request->driver != 'null' && $this->request->agent != 'null' && $this->request->status == 'null') {
            $driver = User::find($this->request->driver);
            $agent = User::find($this->request->agent);
            $order = Order::with('cargo', 'agent', 'tracker.cargolocation', 'tracker.user', 'tracker.agent', 'order', 'payer')->whereHas('tracker', function ($q) {
                $q->where('driver_id', $this->request->driver);
            })->whereHas('tracker', function ($q) {
                $q->where('agent_id', $this->request->agent);
            })->get();

            return view('backend.exports.reports', [
                'orders' => $order,
                'driver' => $driver,
                'agent' => $agent,
            ]);
        }
        if ($this->request->driver != 'null' && $this->request->status != 'null' && $this->request->agent == 'null') {
            $driver = User::find($this->request->driver);

            if ($this->request->status == 0) {
                $payer_user = DB::table('payer_user')->where('user_id', Auth::id())->get(['payer_id']);
                return view('backend.exports.reports', [
                    'orders' => Order::with('cargo', 'agent', 'tracker.cargolocation', 'tracker.user', 'tracker.agent', 'order', 'payer')->whereIn('payer_id', $payer_user->pluck('payer_id'))->whereHas('tracker', function ($q) {
                        $q->where('driver_id', $this->request->driver);
                    })->get(),
                    'driver' => $driver
                ]);
            }
            if ($this->request->status == 2) {
                return view('backend.exports.reports', [
                    'orders' => Order::with('cargo', 'agent', 'tracker.cargolocation', 'tracker.user', 'tracker.agent', 'order', 'payer')->whereIn('status_id', [2, 3, 4, 5, 8])->whereBetween('delivery_time', [$start, $end])->whereHas('tracker', function ($q) {
                        $q->where('driver_id', $this->request->driver);
                    })->get(),
                    'driver' => $driver
                ]);
            }
            return view('backend.exports.reports', [
                'orders' => Order::with('cargo', 'agent', 'tracker.cargolocation', 'tracker.user', 'tracker.agent', 'order', 'payer')->where('status_id', $this->request->status)->whereBetween('delivery_time', [$start, $end])->whereHas('tracker', function ($q) {
                    $q->where('driver_id', $this->request->driver);
                })->get(),
                'driver' => $driver
            ]);
        }
        if ($this->request->agent != 'null' && $this->request->status != 'null' && $this->request->driver == 'null') {
            $agent = User::find($this->request->agent);
            if ($this->request->status == 0) {
                $payer_user = DB::table('payer_user')->where('user_id', Auth::id())->get(['payer_id']);
                return view('backend.exports.reports', [
                    'orders' => Order::with('cargo', 'agent', 'tracker.cargolocation', 'tracker.user', 'tracker.agent', 'order', 'payer')->whereIn('payer_id', $payer_user->pluck('payer_id'))->whereHas('tracker', function ($q) {
                        $q->where('agent_id', $this->request->agent);
                    })->get(),
                    'agent' => $agent
                ]);
            }
            if ($this->request->status == 2) {
                return view('backend.exports.reports', [
                    'orders' => Order::with('cargo', 'agent', 'tracker.cargolocation', 'tracker.user', 'tracker.agent', 'order', 'payer')->whereIn('status_id', [2, 3, 4, 5, 8])->whereBetween('delivery_time', [$start, $end])->whereHas('tracker', function ($q) {
                        $q->where('agent_id', $this->request->agent);
                    })->get(),
                    'agent' => $agent
                ]);
            }
            return view('backend.exports.reports', [
                'orders' => Order::with('cargo', 'agent', 'tracker.cargolocation', 'tracker.user', 'tracker.agent', 'order', 'payer')->where('status_id', $this->request->status)->whereBetween('delivery_time', [$start, $end])->whereHas('tracker', function ($q) {
                    $q->where('agent_id', $this->request->agent);
                })->get(),
                'agent' => $agent
            ]);
        }
        if ($this->request->driver != 'null' && $this->request->agent != 'null' && $this->request->status != 'null') {
            $driver = User::find($this->request->driver);
            $agent = User::find($this->request->agent);

            if ($this->request->status == 0) {
                $payer_user = DB::table('payer_user')->where('user_id', Auth::id())->get(['payer_id']);
                return view('backend.exports.reports', [
                    'orders' => Order::with('cargo', 'agent', 'tracker.cargolocation', 'tracker.user', 'tracker.agent', 'order', 'payer')->whereIn('payer_id', $payer_user->pluck('payer_id'))->whereHas('tracker', function ($q) {
                        $q->where('driver_id', $this->request->driver);
                    })->whereHas('tracker', function ($q) {
                        $q->where('agent_id', $this->request->agent);
                    })->get(),
                    'driver' => $driver,
                    'agent' => $agent,
                ]);
            }
            if ($this->request->status == 2) {
                return view('backend.exports.reports', [
                    'orders' => Order::with('cargo', 'agent', 'tracker.cargolocation', 'tracker.user', 'tracker.agent', 'order', 'payer')->whereIn('status_id', [2, 3, 4, 5, 8])->whereBetween('delivery_time', [$start, $end])->whereHas('tracker', function ($q) {
                        $q->where('driver_id', $this->request->driver);
                    })->whereHas('tracker', function ($q) {
                        $q->where('agent_id', $this->request->agent);
                    })->get(),
                    'driver' => $driver,
                    'agent' => $agent,
                ]);
            }
            return view('backend.exports.reports', [
                'orders' => Order::with('cargo', 'agent', 'tracker.cargolocation', 'tracker.user', 'tracker.agent', 'order', 'payer')->where('status_id', $this->request->status)->whereBetween('delivery_time', [$start, $end])->whereHas('tracker', function ($q) {
                    $q->where('driver_id', $this->request->driver);
                })->whereHas('tracker', function ($q) {
                    $q->where('agent_id', $this->request->agent);
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
