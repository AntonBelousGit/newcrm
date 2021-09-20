<?php

namespace App\Mail;

use App\Models\CargoLocation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReceiveNotifications extends Mailable
{
    use Queueable, SerializesModels;

    private $orders;
    private $request;
    private $tracker;
    /**
     * @var mixed|null
     */


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($orders, $request = null, $tracker = null)
    {
        $this->orders = $orders;
        $this->request = $request;
        $this->tracker = $tracker;

    }

    public function searchLocation($request)
    {
//        dd($request);
        $location = CargoLocation::find($request->time[0]['cargo_location']);
//        dd($location);
        return $location->city;
    }

    public function subjectNotifications($shipment)
    {

        if ($shipment->status_id == 3) {
            return 'Picked-up>' . $this->searchLocation($this->request);
        } elseif ($shipment->status_id == 5) {
            return 'POD pending';
        } elseif ($shipment->status_id == 6) {
            return 'Delivered';
        }
        abort(503);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from('NoReplay@g-star.network', 'Shipment Airxps Notification')
            ->subject($this->subjectNotifications($this->orders))
            ->view('backend.mail.receiveNotifications', ['orders' => $this->orders, 'tracker' => $this->tracker]);
    }
}
