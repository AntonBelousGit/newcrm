<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReceiveNotifications extends Mailable
{
    use Queueable, SerializesModels;


    private $orders;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function subjectNotifications($shipment)
    {

        if ($shipment->status_id == 8)
        {
            if ($shipment->tracker->where('position','1')->count() == 1){
                return $shipment->tracker->where('position','1')->pluck('cargolocation',)->first()->name;
            }
            else{
                return $shipment->tracker->where('position','1')->where('status','Arrived')->last()->cargolocation->name;
            }
        }
        elseif ($shipment->status_id == 3){
            return $shipment->status->name.' ->'. $shipment->tracker->where('position','1')->pluck('cargolocation',)->first()->name;
        }
        elseif ($shipment->status_id == 4){
            return $shipment->tracker->where('position','1')->where('status','Arrived')->last()->cargolocation->name.' ->'.$shipment->tracker->where('position','1')->where('status','Awaiting arrival')->first()->cargolocation->name;
        }
        else
        {
            return $shipment->status->name;
        }

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('NoReplay@g-star.network', 'Shipment Airxps Notification')->subject($this->subjectNotifications($this->orders))->view('backend.mail.receiveNotifications');
    }
}
