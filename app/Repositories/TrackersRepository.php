<?php

namespace App\Repositories;

use App\Mail\ReceiveNotifications;
use App\Models\Order;
use App\Models\Tracker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class TrackersRepository
{
    protected $tracker;

    public function __construct(Tracker $tracker)
    {
        $this->tracker = $tracker;
    }

    public function getTrackerById($id)
    {
        return Tracker::findOrFail($id);
    }

    public function getStartTracker($order)
    {
        return Tracker::with('cargolocation')->where('order_id', $order->id)->where('position', '0')->first();
    }

    public function getEndTracker($order)
    {
        return Tracker::with('cargolocation')->where('order_id', $order->id)->where('position', '2')->first();

    }

    public function updateStartTracker($order, $request, $many)
    {
//        dd($order);
        $tracker_start = $this->getStartTracker($order);

        $tracker_start_old = $tracker_start->status;
        $start = $request->start;

        $tracker_start->driver_id = $start['driver_id'] ?? null;
        if (!is_null($start['start_time']) && !is_null($start['start_time_stop'])) {
            $tracker_start->start_time = str_replace('T', ' ', $start['start_time']);
            $tracker_start->start_time_stop = str_replace('T', ' ', $start['start_time_stop']);
        }
        if (!is_null($start['arrived_time'])) {
            $tracker_start->end_time = str_replace('T', ' ', $start['arrived_time']);
        }

        if (isset($start['status_arrival']) || isset($start['arrived_time'])) {
            $tracker_start->end_time = $tracker_start->end_time ?? now();
            $tracker_start->alert = ($tracker_start->start_time < $tracker_start->end_time && $tracker_start->end_time < $tracker_start->start_time_stop)? 'ok':'bad';
            $tracker_start->status = 'Arrived';
//            dd($start);
        }
        if (!empty($start['signed'])) {
            $tracker_start->signed = $start['signed'];
            if ($many == false) {
                $order->status_id = 5;

            } else {
                $order->status_id = 3;
            }
            if ((isset($start['status_arrival']) || isset($start['arrived_time'])) && $order->notifications === 'on' && $tracker_start_old === 'Awaiting arrival' && !empty($order->email)) {
             foreach (explode(',',$order->email) as $mail) {
                 Mail::to($mail)->send(new ReceiveNotifications($order, $request, $tracker_start));
             }
            }
        }
        $order->update();


        $tracker_start->update();

        $tracker_end = $this->getEndTracker($order);
        $tracker_end->driver_id = $tracker_start->driver_id;
        $tracker_end->update();

    }

    public function updateEndTracker($order, $request)
    {
        $tracker_end = $this->getEndTracker($order);
        $end = $request->end;
        $tracker_end->signed = '';
//        $tracker_end->driver_id = $end['driver_id'] ?? null;
        if (!is_null($end['start_time'])) {
            $tracker_end->start_time = str_replace('T', ' ', $end['start_time']);
            $tracker_end->start_time_stop = str_replace('T', ' ', $end['start_time_stop']);
        }

        if (!is_null($end['arrived_time'])) {
            $tracker_end->end_time = str_replace('T', ' ', $end['arrived_time']);
        }

        if (isset($end['status_arrival']) || (isset($end['arrived_time']) && !empty($end['signed']))) {
            $tracker_end->end_time = $tracker_end->end_time ?? now();
            $tracker_end->alert = ($tracker_end->start_time < $tracker_end->end_time && $tracker_end->end_time < $tracker_end->start_time_stop)? 'ok':'bad';

            $tracker_end->signed = $end['signed'];
            $tracker_end->status = 'Arrived';
            $order->status_id = 6;
            $order->delivery_time = now()->format('Y-m-d');
            $order->update();
            if (isset($end['status_arrival']) || (isset($end['arrived_time']) && $order->notifications == 'on')) {
                if (!empty($order->email)) {
                    foreach (explode(',', $order->email) as $mail) {
                        Mail::to($mail)->send(new ReceiveNotifications($order, $request, $tracker_end));
                    }
                }
            }
        }
        if (!is_null($request->checkout_number)) {

            $order->checkout_number = $request->checkout_number;
            $order->status_id = 9;
            $order->update();
        }
        $tracker_end->update();
    }

    public function updateTransitionalTracker($order, $option_key, $many)
    {
        $tracker = $this->getTrackerById($option_key['id']);

        $tracker->order_id = $order->id;
        $tracker->driver_id = $option_key['driver_id'] ?? null;
        $tracker->location_id = $option_key['cargo_location'];
        $tracker->address = $option_key['address'];
        $tracker->signed = $option_key['signed'] ?? null;

        if (!$many) {

            if (!is_null($option_key['start_time'])) {
                $tracker->start_time = str_replace('T', ' ', $option_key['start_time']);
            }
            if (!is_null($option_key['arrived_time'])) {
                $tracker->end_time = str_replace('T', ' ', $option_key['arrived_time']);
            }
            if (isset($option_key['status_arrival']) || $option_key['arrived_time']) {
                $tracker->end_time = $tracker->end_time ?? now();
                $tracker->alert = $tracker->end_time > $tracker->start_time ? 'bad' : 'ok';
                $tracker->status = 'Arrived';
                $order->status_id = 8;
                $order->update();
            }
            if (isset($option_key['status_left'])) {
                $tracker->left_the_point = now();
                $order->status_id = 5;
                $order->update();
            }
        } else {
            if (!is_null($option_key['start_time'])) {
                $tracker->start_time = str_replace('T', ' ', $option_key['start_time']);
            }
            if (!is_null($option_key['arrived_time'])) {
                $tracker->end_time = str_replace('T', ' ', $option_key['arrived_time']);
            }
            if (isset($option_key['status_arrival']) || $option_key['arrived_time']) {
                $tracker->end_time = $tracker->end_time ?? now();
                $tracker->alert = $tracker->end_time > $tracker->start_time ? 'bad' : 'ok';
                $tracker->status = 'Arrived';
                $order->status_id = 8;
                $order->update();
            }
            if (isset($option_key['status_left'])) {
                $count = Tracker::where('order_id', $order->id)->where('position', '1')->where('status', 'Awaiting arrival')->count();
                if ($count != 0) {
                    $tracker->left_the_point = now();
                    $order->status_id = 4;
                    $order->update();
                } else {
                    $tracker->left_the_point = now();
                    $order->status_id = 5;
                    $order->update();
                }

            }
        }


        $tracker->update();

        $tracker_end = $this->getEndTracker($order);
        $tracker_end->driver_id = $tracker->driver_id;
        $tracker_end->update();
    }

    public function createTransitionalTracker($order, $option_key, $many)
    {
        $tracker = new Tracker();
        $tracker->order_id = $order->id;
        $tracker->driver_id = $option_key['driver_id'] ?? null;
        $tracker->location_id = $option_key['cargo_location'];
        $tracker->address = $option_key['address'];
        $tracker->signed = $option_key['signed'] ?? null;
        if (!is_null($option_key['start_time'])) {
            $tracker->start_time = str_replace('T', ' ', $option_key['start_time']);
        }
        if (!is_null($option_key['arrived_time'])) {
            $tracker->end_time = str_replace('T', ' ', $option_key['arrived_time']);
        }
        if (isset($option_key['status_arrival']) || isset($option_key['arrived_time'])) {
            $tracker->end_time = $tracker->end_time ?? now();
            $tracker->alert = $tracker->end_time > $tracker->start_time ? 'bad' : 'ok';
            $tracker->status = 'Arrived';
            $order->status_id = 8;
            $order->update();
        }
        if (isset($option_key['status_left'])) {
            $tracker->left_the_point = now();
            $order->status_id = 5;
            $order->update();
        }

        $tracker->save();
    }

//DRIVER and AGENT

    public function updateDriverStartTracker($order, $request, $many)
    {
        $tracker_start = $this->getStartTracker($order);
//        dd($tracker_start);
        $start = $request->start;
        $tracker_start->driver_id = $start['driver_id'] ?? null;

        if (isset($start['status_arrival'])) {
            $tracker_start->end_time = now();
//            $tracker_start->alert = $tracker_start->end_time > $tracker_start->start_time ? 'bad' : 'ok';
            $tracker_start->alert = ($tracker_start->start_time < $tracker_start->end_time && $tracker_start->end_time < $tracker_start->start_time_stop)? 'ok':'bad';

        }
        if (isset($start['status_arrival'])  && !empty($start['signed'])) {
            $tracker_start->signed = $start['signed'];
            $tracker_start->status = 'Arrived';

            if ($many == false) {
                $order->status_id = 5;
            } else {
                $order->status_id = 3;
            }
            if (isset($start['status_arrival']) && $order->notifications == 'on') {
                if (!empty($order->email)) {
                    foreach (explode(',', $order->email) as $mail) {
                        Mail::to($mail)->send(new ReceiveNotifications($order, $request, $tracker_start));
                    }
                }
            }
            $order->update();
        }

        $tracker_start->update();
    }

    public function updateDriverEndTracker($order, $request)
    {
        $tracker_end = $this->getEndTracker($order);
        $end = $request->end;
        $tracker_end->signed = '';
        $tracker_end->driver_id = $end['driver_id'] ?? null;


        if (isset($end['status_arrival'])) {
            $tracker_end->end_time = now();
            $tracker_end->alert = ($tracker_end->start_time < $tracker_end->end_time && $tracker_end->end_time < $tracker_end->start_time_stop)? 'ok':'bad';

            $tracker_end->signed = $end['signed'];
            $tracker_end->status = 'Arrived';
            $order->status_id = 6;
            $order->update();

            if (isset($end['status_arrival']) && $order->notifications == 'on') {
                if (!empty($order->email)) {
                    foreach (explode(',', $order->email) as $mail) {
                        Mail::to($mail)->send(new ReceiveNotifications($order, $request, $tracker_end));
                    }
                }
            }
        }
        $tracker_end->update();
    }

    public function updateDriverTransitionalTracker($order, $option_key, $many)
    {
//        dd($option_key);

        $tracker = $this->getTrackerById($option_key['tracker_id']);

        $tracker->order_id = $order->id;

        if (!$many) {


            if (isset($option_key['status_arrival'])) {
                $tracker->end_time = now();
                $tracker->alert = $tracker->end_time > $tracker->start_time ? 'bad' : 'ok';
                $tracker->status = 'Arrived';
                $order->status_id = 8;
                $order->update();
            }
            if (isset($option_key['status_left'])) {
                $tracker->left_the_point = now();
                $order->status_id = 5;
                $order->update();
            }
        } else {
            if (isset($option_key['status_arrival'])) {
                $tracker->end_time = now();
                $tracker->alert = $tracker->end_time > $tracker->start_time ? 'bad' : 'ok';
                $tracker->status = 'Arrived';
                $order->status_id = 8;
                $order->update();
            }
            if (isset($option_key['status_left'])) {
                $count = Tracker::where('order_id', $order->id)->where('position', '1')->where('status', 'Awaiting arrival')->count();
                if ($count != 0) {
                    $tracker->left_the_point = now();
                    $order->status_id = 4;
                    $order->update();
                } else {
                    $tracker->left_the_point = now();
                    $order->status_id = 5;
                    $order->update();
                }

            }
        }


        $tracker->update();
    }


}
