<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCargo extends Model
{
    use HasFactory;
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
}
