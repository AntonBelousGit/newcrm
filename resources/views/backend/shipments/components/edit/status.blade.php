@php
    if ($orders->status_id == 8)
    {
        if ($orders->tracker->where('position','1')->count() == 1){
            echo  $orders->tracker->where('position','1')->pluck('cargolocation')->first()->name  ;
            $location_name=!is_null($orders->tracker->where('position','1')->where('status','Awaiting arrival')->first())?$orders->tracker->where('position','1')->where('status','Awaiting arrival')->first()->cargolocation->name:$orders->tracker->where('position','2')->where('status','Awaiting arrival')->first()->cargolocation->name;
        }
        else{
            echo  $orders->tracker->where('position','1')->where('status','Arrived')->last()->cargolocation->name  ;
            $location_name=!is_null($orders->tracker->where('position','1')->where('status','Awaiting arrival')->first())?$orders->tracker->where('position','1')->where('status','Awaiting arrival')->first()->cargolocation->name:$orders->tracker->where('position','2')->where('status','Awaiting arrival')->first()->cargolocation->name;
        }
    }
    elseif ($orders->status_id == 3){
       echo  $orders->status->name.' ->'. $orders->tracker->where('position','1')->pluck('cargolocation')->first()->name  ;
    }
    elseif ($orders->status_id == 4){
        $location_name=!is_null($orders->tracker->where('position','1')->where('status','Awaiting arrival')->first())?$orders->tracker->where('position','1')->where('status','Awaiting arrival')->first()->cargolocation->name:$orders->tracker->where('position','2')->where('status','Awaiting arrival')->first()->cargolocation->name;
         if($orders->tracker->where('position','1')->where('status','Awaiting arrival')->count() === 0)
        {
          echo  $orders->tracker->where('position','1')->where('status','Arrived')->last()->cargolocation->name.' ->'. $location_name .'+POD Pending</th>';
        }
        else
        {
           echo  $orders->tracker->where('position','1')->where('status','Arrived')->last()->cargolocation->name.' ->'. $location_name   ;
        }
    }
    elseif ($orders->status_id == 5){
        echo   $orders->tracker->where('position','0')->first()->cargolocation->name .'->'. $orders->tracker->where('position','2')->first()->cargolocation->name .'+'.$orders->status->name  ;
    }
    else
    {
       echo  $orders->status->name  ;
    }
@endphp
