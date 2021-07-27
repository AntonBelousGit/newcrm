<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;
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
