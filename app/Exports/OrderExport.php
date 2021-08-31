<?php

namespace App\Exports;

use App\Http\Controllers\Admin\ReportController;
use App\Models\Order;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrderExport implements FromView
{
    protected $request;

    function __construct($request) {
        $this->request = $request;
    }

    public function view(): View
    {

//        dd($this->request);
        $start = $this->request->start;
        $end = $this->request->end;

        return view('backend.exports.reports', [
            'orders' => Order::with('cargo', 'agent', 'tracker.cargolocation','tracker.user', 'order','payer')->where('status_id', $this->request->status)->whereBetween('delivery_time',[$start,$end])->get()
        ]);
    }


}
