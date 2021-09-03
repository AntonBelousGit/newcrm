<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    protected $orderService;


    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;

    }

    public function index(){
       if (Gate::any(['SuperUser', 'Manager', 'OPS', 'Agent', 'Driver', 'Client'], Auth::user())) {
           $orders = $this->orderService->getAll();
           $title = 'All Shipments';
           $dashboard = true;
           return view('backend.shipments.index', compact('orders', 'title','dashboard'));
       }
       return abort(403);
   }
}
