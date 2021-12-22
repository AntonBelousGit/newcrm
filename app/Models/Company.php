<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;


    public function location()
    {
        return $this->belongsTo(CargoLocation::class, 'location_id');

    }

    public function user()
    {
        return $this->belongsToMany(
            User::class,
            'company_user',
            'company_id',
            'user_id'
        );
    }

    public function userAgent()
    {
        return $this->belongsToMany(User::class)->wherePivot('type', 'agent');
    }
    public function userDriver()
    {
        return $this->belongsToMany(User::class)->wherePivot('type', 'driver');
    }
}
