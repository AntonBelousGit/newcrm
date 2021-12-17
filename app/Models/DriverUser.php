<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverUser extends Model
{
    use HasFactory;

    protected $fillable = ['car_model','gos_number_car','phone','agent_user_id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');

    }
    public function company()
    {
        return $this->belongsTo('App\Models\AgentUser','agent_user_id');
    }
}
