<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrderService
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository){
        $this->orderRepository = $orderRepository;
    }
    public function getAll()
    {
        return $this->orderRepository->getAll();
    }

    public function saveOrder($request){
        return $this->orderRepository->saveOrder($request);
    }
    public function saveReturnedOrder($request,$id){
        return $this->orderRepository->saveReturnedOrder($request,$id);
    }
    public function findAndUpdate($request,$id){
        return $this->orderRepository->findAndUpdate($request,$id);
    }
}