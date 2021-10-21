<?php

namespace App\Exports;

use App\Http\Controllers\Admin\ReportController;
use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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


        if ($this->request->status == 0) {
            $payer_user = DB::table('payer_user')->where('user_id', Auth::id())->get(['payer_id']);
            return view('backend.exports.reports', [
                'orders' => Order::with('cargo', 'agent', 'tracker.cargolocation','tracker.user', 'order','payer')->whereIn('payer_id', $payer_user->pluck('payer_id'))->get()
            ]);
        }
        if ($this->request->status == 2) {
            return view('backend.exports.reports', [
                'orders' => Order::with('cargo', 'agent', 'tracker.cargolocation','tracker.user', 'order','payer')->whereIn('status_id', [2, 3, 4, 5, 8])->whereBetween('delivery_time',[$start,$end])->get()
            ]);
        }
        return view('backend.exports.reports', [
            'orders' => Order::with('cargo', 'agent', 'tracker.cargolocation','tracker.user', 'order','payer')->where('status_id', $this->request->status)->whereBetween('delivery_time',[$start,$end])->get()
        ]);

    }


}
