<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrderExport implements FromView
{
    public function view(): View
    {
//        dd(Order::all());
        return view('backend.exports.reports', [
            'orders' => Order::all()
        ]);
    }


}
