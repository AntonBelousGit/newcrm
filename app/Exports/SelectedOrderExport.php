<?php

namespace App\Exports;

use App\Http\Controllers\Admin\ReportController;
use App\Models\Order;
use Illuminate\Contracts\View\View;
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
        return view('backend.exports.selected_orders', [
            'orders' => Order::with('cargo', 'tracker.cargolocation','shipper_city','consignee_city', 'order')->whereIn('id', $this->request)->get()
        ]);
    }
}
