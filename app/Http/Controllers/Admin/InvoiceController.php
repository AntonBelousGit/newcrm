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
        $image = base64_encode(file_get_contents(public_path('assets/img/logo.png')));
        $pdf = PDF::loadView('backend.pdf.invoices',compact('invoices','tracker_start','tracker_end','image'));
//        $pdf->setPaper('A4', 'landscape');
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download('HWB.pdf');
    }

    public function testPDF()
    {
        $invoices = Order::find(1);
        $tracker_start = Tracker::with('cargolocation')->where('order_id', 1)->where('position', '0')->first();
        $tracker_end = Tracker::with('cargolocation')->where('order_id', 1)->where('position', '2')->first();
        return view('backend.pdf.invoices',compact('invoices','tracker_start','tracker_end'));
    }
}
