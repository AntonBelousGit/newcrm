<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class InvoiceController extends Controller
{
    public function downloadPDF($id)
    {
        $invoices = Order::find($id);
        $pdf = PDF::loadView('backend.pdf.invoices',compact('invoices'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('invoice.pdf');
    }
}
