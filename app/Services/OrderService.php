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
    public function getAllParentOrder()
    {
        return $this->orderRepository->getAllParentOrder();
    }
    public function saveOrder($request){
        return $this->orderRepository->saveOrder($request);
    }
    public function saveReturnedOrder($request,$id,$email){
        return $this->orderRepository->saveReturnedOrder($request,$id,$email);
    }
    public function findAndUpdate($request,$id){
        return $this->orderRepository->findAndUpdate($request,$id);
    }
    public function createCargo($request,$order){
        return $this->orderRepository->createCargo($request,$order);
    }
    public function dublicate($order){
        return $this->orderRepository->dublicate($order);
    }
}
