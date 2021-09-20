<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Cargo extends Model
{
    use HasFactory, LogsActivity;

    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = [ 'updated_at','created_at' ];
    protected static $submitEmptyLogs = false;
    protected static $logName = 'Cargo';

    protected $fillable = [
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


