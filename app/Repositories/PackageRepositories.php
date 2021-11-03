<?php

namespace App\Repositories;

use App\Models\Cargo;
use App\Models\Order;

class PackageRepositories
{
    protected $package;

    public function __construct(Cargo $package)
    {
        $this->package = $package;
    }

    public function duplicate($new_order,$order)
    {
       $cargos = $this->findCargo($order->id);

       foreach($cargos as $cargo)
       {
           $new_cargo = $cargo->replicate();
           $new_cargo->order_id = $new_order->id;
           $new_cargo->save();
       }
    }

    public function findCargo($id)
    {
        return Cargo::where('order_id',$id)->get();
    }
}
