<?php

namespace App\Services;

use App\Repositories\TrackersRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TrackerService
{
    protected $trackerRepository;

    public function __construct(TrackersRepository $trackerRepository)
    {
        $this->trackerRepository = $trackerRepository;
    }

    public function updateStartTracker($order, $request, $many)
    {
        $this->trackerRepository->updateStartTracker($order, $request, $many);
    }

    public function updateEndTracker($order, $request)
    {
        $this->trackerRepository->updateEndTracker($order, $request);
    }

    public function getStartTracker($order)
    {
        $this->trackerRepository->getStartTracker($order);
    }

    public function getEndTracker($order)
    {
        $this->trackerRepository->getEndTracker($order);
    }

    public function getTrackerById($id)
    {
        $this->trackerRepository->getTrackerById($id);
    }

    public function updateTransitionalTracker($order, $option_key, $many)
    {
        $this->trackerRepository->updateTransitionalTracker($order, $option_key, $many);
    }

    public function createTransitionalTracker($order, $option_key, $many)
    {
        $this->trackerRepository->createTransitionalTracker($order, $option_key, $many);
    }


    public function updateDriverStartTracker($order, $request, $many)
    {
        $this->trackerRepository->updateDriverStartTracker($order, $request, $many);
    }

    public function updateDriverEndTracker($order, $request)
    {
        $this->trackerRepository->updateDriverEndTracker($order, $request);
    }

    public function updateDriverTransitionalTracker($order, $option_key, $many)
    {
        $this->trackerRepository->updateDriverTransitionalTracker($order, $option_key, $many);
    }

    public function dublicate($new_order, $order)
    {
        $this->trackerRepository->dublicate($new_order, $order);
    }
}
