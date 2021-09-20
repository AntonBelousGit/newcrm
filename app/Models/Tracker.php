<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Tracker extends Model
{
    use HasFactory, LogsActivity;

    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*','cargolocation.city'];
    protected static $logAttributesToIgnore = [ 'updated_at','created_at' ];
    protected static $submitEmptyLogs = false;
    protected static $logName = 'Tracker';


    public function cargolocation()
    {
        return $this->belongsTo('App\Models\CargoLocation','location_id');

    }
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'driver_id');

    }
}
