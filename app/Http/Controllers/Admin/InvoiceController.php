<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Tracker;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class InvoiceController extends Controller
{
    public function downloadPDF($id)
    {
        $invoices = Order::find($id);
        $tracker_start = Tracker::with('cargolocation')->where('order_id', $id)->where('position', '0')->first();
        $tracker_end = Tracker::with('cargolocation')->where('order_id', $id)->where('position', '2')->first();
        $pdf = PDF::loadView('backend.pdf.invoices',compact('invoices','tracker_start','tracker_end'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('HWB.pdf');
    }
}
