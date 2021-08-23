<?php

namespace App\Repositories;

use App\Models\Tracker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
//        dd($many);
        $tracker_start = $this->getStartTracker($order);
        $start = $request->start;
        $tracker_start->driver_id = $start['driver_id'] ?? null;
        if (!is_null($start['start_time'])) {
            $tracker_start->start_time = str_replace('T', ' ', $start['start_time']);
        }
        if (!is_null($start['left_the_point'])) {
            $tracker_start->left_the_point = str_replace('T', ' ', $start['left_the_point']);
        }
        if (!is_null($start['end_time'])) {
            $tracker_start->end_time = str_replace('T', ' ', $start['end_time']);
            $tracker_start->alert = $tracker_start->end_time > $tracker_start->start_time ? 'bad' : 'ok';

        }
        if (!is_null($start['end_time']) && !empty($start['signed'])) {
            $tracker_start->signed = $start['signed'];
            $tracker_start->status = 'Arrived';

            if ($many == false) {
                $order->status_id = 5;
            } else {
                $order->status_id = 3;
            }

            $order->update();
        }

        $tracker_start->update();
    }

    public function updateEndTracker($order, $request)
    {
        $tracker_end = $this->getEndTracker($order);
        $end = $request->end;
        $tracker_end->signed = '';
        $tracker_end->driver_id = $end['driver_id'] ?? null;
        if (!is_null($end['start_time'])) {
            $tracker_end->start_time = str_replace('T', ' ', $end['start_time']);
        }
        if (!is_null($end['end_time'])) {
            $tracker_end->end_time = str_replace('T', ' ', $end['end_time']);
            $tracker_end->alert = $tracker_end->end_time > $tracker_end->start_time ? 'bad' : 'ok';
            $tracker_end->signed = $end['signed'];
            $tracker_end->status = 'Arrived';
            $order->status_id = 6;
            $order->update();
        }
        if (!is_null($request->checkout_number)) {

            $order->checkout_number = $request->checkout_number;
            $order->status_id = 7;
            $order->update();
        }
        $tracker_end->update();
    }

    public function updateTransitionalTracker($order, $option_key, $many)
    {
        $tracker = $this->getTrackerById($option_key['id']);

        $pizda = Tracker::where('order_id', $order->id)->where('position', '1')->get();

//        dd($option_key);

        $tracker->order_id = $order->id;
        $tracker->driver_id = $option_key['driver_id'] ?? null;
        $tracker->location_id = $option_key['cargo_location'];
        $tracker->address = $option_key['address'];
        if (!is_null($option_key['start_time'])) {
            $tracker->start_time = str_replace('T', ' ', $option_key['start_time']);
        }
        if (!is_null($option_key['end_time'])) {
            $tracker->end_time = str_replace('T', ' ', $option_key['end_time']);
            $tracker->alert = $tracker->end_time > $tracker->start_time ? 'bad' : 'ok';
            $tracker->status = 'Arrived';
            $order->status_id = 8;
            $order->update();
        }
        if (!is_null($option_key['left_the_point'])) {
            $tracker->left_the_point = str_replace('T', ' ', $option_key['left_the_point']);
            $order->status_id = 5;
            $order->update();
        }
        $tracker->update();
    }

    public function createTransitionalTracker($order, $option_key, $many)
    {
        $tracker = new Tracker();
        $tracker->order_id = $order->id;
        $tracker->driver_id = $option_key['driver_id'] ?? null;
        $tracker->location_id = $option_key['cargo_location'];
        $tracker->address = $option_key['address'];
        if (!is_null($option_key['start_time'])) {
            $tracker->start_time = str_replace('T', ' ', $option_key['start_time']);
        }
        if (!is_null($option_key['left_the_point'])) {
            $tracker->left_the_point = str_replace('T', ' ', $option_key['left_the_point']);
        }
        if (!is_null($option_key['end_time'])) {
            $tracker->end_time = str_replace('T', ' ', $option_key['end_time']);
            $tracker->alert = $tracker->end_time > $tracker->start_time ? 'bad' : '';
            $tracker->status = 'Arrived';
            $order->status_id = 8;
            $order->update();
        }
        if (!is_null($option_key['left_the_point'])) {
            $tracker->left_the_point = str_replace('T', ' ', $option_key['left_the_point']);
            $order->status_id = 5;
            $order->update();
        }

        $tracker->save();
    }
}
