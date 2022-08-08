<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Tracker;
use DateTime;
use Illuminate\Http\Request;

class ApiTrackerController extends Controller
{
    public function responseTracker(Request $request)
    {
        $validated_data = $this->validate($request, [
            'tracker' => 'required',
        ]);
        $headers = ['Content-Type' => 'application/json; charset=utf-8; Access-Control-Allow-Origin: *'];
        $id = (int)$validated_data['tracker'];

        if (Order::find($id)) {
            $trackers = $this->show_child_row($id);
            $data = ['tracker' => $trackers];
            return response()->json($data, 200, $headers, JSON_UNESCAPED_UNICODE);
        }
        $data = ['tracker' => 'Not found'];

        return response()->json($data, 200, $headers, JSON_UNESCAPED_UNICODE);

    }

    /**
     * @param integer $id
     * @return array
     */
    public function show_child_row(int $id)
    {
        $start_point = Tracker::where('order_id', $id)->where('position', '0')->with('cargolocation')->first(['start_time', 'start_time_stop', 'end_time', 'end_time_stop', 'alert', 'status', 'location_id']);
        $tracker[] = $this->time_tracker($start_point);
        $intermediate_trackers = Tracker::where('order_id', $id)->where('position', '1')->with('cargolocation')->get(['start_time', 'start_time_stop', 'end_time', 'end_time_stop', 'alert', 'status', 'location_id']);
        foreach ($intermediate_trackers as $item) {
            $tracker[] = $this->time_tracker($item);
        }
        $end_point = Tracker::where('order_id', $id)->where('position', '2')->with('cargolocation')->first(['start_time', 'start_time_stop', 'end_time', 'end_time_stop', 'alert', 'status', 'location_id']);
        $tracker[] = $this->time_tracker($end_point);
        return $tracker;
    }

    public function time_tracker($time)
    {
        //Предположительное время
        if (isset($time->start_time)) {
            $start_time = new DateTime($time->start_time);
            $time->start_hour = $start_time->format('H:i');
            $time->start_date = $start_time->format('d.m.Y ');
        } else {
            $time->start_hour = '';
            $time->start_date = 'set the date';
        }
        //Фактическое время
        if (isset($time->end_time)) {
            $end_time = new DateTime($time->end_time);
            $time->end_hour = $end_time->format('d.m.Y (H:i)');
        } else {
            $time->end_hour = '';
        }
        return $time;
    }
}
