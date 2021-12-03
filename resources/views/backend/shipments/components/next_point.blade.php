@php
    if ($shipment->status_id == 8)
    {
        if ($shipment->tracker->where('position','1')->count() == 1){
            echo '<th>'.$shipment->tracker->where('position','1')->pluck('cargolocation')->first()->name.'</th>';
            $location_name=!is_null($shipment->tracker->where('position','1')->where('status','Awaiting arrival')->first())?$shipment->tracker->where('position','1')->where('status','Awaiting arrival')->first()->cargolocation->name:$shipment->tracker->where('position','2')->where('status','Awaiting arrival')->first()->cargolocation->name;
            echo '<th>'.$shipment->tracker->where('position','1')->where('status','Arrived')->last()->cargolocation->name.' ->'. $location_name .'</th>';
        }
        else{
            echo '<th>'.$shipment->tracker->where('position','1')->where('status','Arrived')->last()->cargolocation->name.'</th>';
            $location_name=!is_null($shipment->tracker->where('position','1')->where('status','Awaiting arrival')->first())?$shipment->tracker->where('position','1')->where('status','Awaiting arrival')->first()->cargolocation->name:$shipment->tracker->where('position','2')->where('status','Awaiting arrival')->first()->cargolocation->name;
            echo '<th>'.$shipment->tracker->where('position','1')->where('status','Arrived')->last()->cargolocation->name.' ->'. $location_name .'</th>';
        }
    }
    elseif ($shipment->status_id == 3){
       echo '<th>'.$shipment->status->name.' ->'. $shipment->tracker->where('position','1')->pluck('cargolocation')->first()->name.'</th>';
       echo '<th>'.$shipment->tracker->where('position','1')->pluck('cargolocation')->first()->name.'</th>';
    }
    elseif ($shipment->status_id == 4){
        $location_name=!is_null($shipment->tracker->where('position','1')->where('status','Awaiting arrival')->first())?$shipment->tracker->where('position','1')->where('status','Awaiting arrival')->first()->cargolocation->name:$shipment->tracker->where('position','2')->where('status','Awaiting arrival')->first()->cargolocation->name;
         if($shipment->tracker->where('position','1')->where('status','Awaiting arrival')->count() === 0)
        {
          echo '<th>'.$shipment->tracker->where('position','1')->where('status','Arrived')->last()->cargolocation->name.' ->'. $location_name .'+POD Pending</th>';
        }
        else
        {
           echo '<th>'.$shipment->tracker->where('position','1')->where('status','Arrived')->last()->cargolocation->name.' ->'. $location_name .'</th>';
        }
        echo '<th>'.$location_name.'</th>';
    }
    elseif ($shipment->status_id == 5){
        echo '<th>'. $shipment->tracker->where('position','0')->first()->cargolocation->name .'->'. $shipment->tracker->where('position','2')->first()->cargolocation->name .'+'.$shipment->status->name.'</th>';
        echo '<th>'.$statuses[$shipment->status_id]->name.'</th>';
    }
    else
    {
       echo '<th>'.$shipment->status->name.'</th>';
       echo '<th>'.$statuses[$shipment->status_id]->name.'</th>';
    }
@endphp
