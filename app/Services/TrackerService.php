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

    public function updateStartTracker($order, $request)
    {
        $this->trackerRepository->updateStartTracker($order, $request);
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
        $this->trackerRepository->getStartTracker($order);
    }

    public function getTrackerById($id)
    {
        $this->trackerRepository->getTrackerById($id);
    }

    public function updateTransitionalTracker($order,$option_key)
    {
        $this->trackerRepository->updateTransitionalTracker($order,$option_key);
    }

    public function createTransitionalTracker($order,$option_key)
    {
        $this->trackerRepository->createTransitionalTracker($order,$option_key);
    }
}
