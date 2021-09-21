<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Cargo extends Model
{
    use HasFactory, LogsActivity;


    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->order_id = $this->order->id;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Cargo')
            ->logAll()
            ->logExcept(['updated_at','created_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();

    }
    public function order()
    {
        return $this->belongsTo('App\Models\Order','order_id');
    }
    protected $fillable = [
        'order_id',
        'quantity',
        'actual_weight',
        'сargo_dimensions_height',
        'сargo_dimensions_length',
        'сargo_dimensions_width',
        'serial_number',
        'serial_number_sensor',
        'un_number',
        'temperature_conditions',
    ];

}


