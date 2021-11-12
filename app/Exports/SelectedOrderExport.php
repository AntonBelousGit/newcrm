<?php

namespace App\Exports;

use App\Http\Controllers\Admin\ReportController;
use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class SelectedOrderExport implements FromView
{
    protected $request;

    function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {

        return view('backend.exports.reports', [
            'orders' => Order::with('cargo', 'agent', 'tracker.cargolocation', 'tracker.user', 'tracker.agent', 'order', 'payer')->where('status_id', $this->request->status)->whereBetween('delivery_time', [$start, $end])->get()
        ]);
    }
}
