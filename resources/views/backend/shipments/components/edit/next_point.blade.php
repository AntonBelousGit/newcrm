@php
    if ($orders->status_id == 8)
    {
        if ($orders->tracker->where('position','1')->count() == 1){
            $location_name=!is_null($orders->tracker->where('position','1')->where('status','Awaiting arrival')->first())?$orders->tracker->where('position','1')->where('status','Awaiting arrival')->first()->cargolocation->name:$orders->tracker->where('position','2')->where('status','Awaiting arrival')->first()->cargolocation->name;
            echo $orders->tracker->where('position','1')->where('status','Arrived')->last()->cargolocation->name.' ->'. $location_name ;
        }
        else{
            $location_name=!is_null($orders->tracker->where('position','1')->where('status','Awaiting arrival')->first())?$orders->tracker->where('position','1')->where('status','Awaiting arrival')->first()->cargolocation->name:$orders->tracker->where('position','2')->where('status','Awaiting arrival')->first()->cargolocation->name;
            echo $orders->tracker->where('position','1')->where('status','Arrived')->last()->cargolocation->name.' ->'. $location_name ;
        }
    }
    elseif ($orders->status_id == 3){
       echo $orders->tracker->where('position','1')->pluck('cargolocation')->first()->name;
    }
    elseif ($orders->status_id == 4){
        $location_name=!is_null($orders->tracker->where('position','1')->where('status','Awaiting arrival')->first())?$orders->tracker->where('position','1')->where('status','Awaiting arrival')->first()->cargolocation->name:$orders->tracker->where('position','2')->where('status','Awaiting arrival')->first()->cargolocation->name;
        echo $statuses[$orders->status_id + 1]->name;
    }
    elseif ($orders->status_id == 5){
        echo $statuses[$orders->status_id]->name;
    }
    else
    {
       echo $statuses[$orders->status_id]->name;
    }
@endphp
