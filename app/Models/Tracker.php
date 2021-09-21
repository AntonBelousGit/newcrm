<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Tracker extends Model
{
    use HasFactory, LogsActivity;

//    protected static $logOnlyDirty = true;
//    protected static $logAttributes = ['*','cargolocation.city'];
//    protected static $logAttributesToIgnore = [ 'updated_at','created_at' ];
//    protected static $submitEmptyLogs = false;
//    protected static $logName = 'Tracker';
    public $incrementing = true;

    protected $fillable =
        [
        'order_id',
        'location_id',
        'address',
        'post_code',
        'start_time',
        'start_time_stop',
        'end_time',
        'end_time_stop',
        'left_the_point',
        'driver_id',
        'tracker_id',
        'signed',
        'status',
        'alert',
        'position',
        ];

    public function order()
    {
        return $this->belongsTo('App\Models\Order','order_id');
    }
    public function cargolocation()
    {
        return $this->belongsTo('App\Models\CargoLocation','location_id');

    }
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'driver_id');

    }
    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->order_id = $this->order->id;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Tracker')
            ->logAll()
            ->logOnlyDirty()
            ->logExcept(['updated_at','created_at'])
            ->dontSubmitEmptyLogs();

    }
}
