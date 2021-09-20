<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class OrderCargo extends Model
{
    use HasFactory, LogsActivity;

    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = [ 'updated_at','created_at' ];
    protected static $submitEmptyLogs = false;
    protected static $logName = 'OrderCargo';

    protected $fillable = [
        'type',
        'quantity',
        'actual_weight',
        'serial_number',
        'serial_number_sensor',
        'un_number',
        'temperature_conditions',
        'volume_weight',

    ];
    public static $aliases = [
        'type' => 'Type',
        'quantity' => 'Quantity',
        'actual_weight' => 'Actual weight',
        'serial_number' => 'Serial number box',
        'serial_number_sensor' => 'Serial number sensor',
        'un_number' => 'UN number',
        'temperature_conditions' => 'Temperature conditions',
        'volume_weight' => 'Volume weight',
        'сargo_dimensions_width' => 'Width',
        'сargo_dimensions_height' => 'Height',
        'сargo_dimensions_length' => 'Length',
    ];
}
