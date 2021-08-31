<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracker extends Model
{
    use HasFactory;

    public function cargolocation()
    {
        return $this->belongsTo('App\Models\CargoLocation','location_id');

    }
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'driver_id');

    }
}
