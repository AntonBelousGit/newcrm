<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentUser extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');

    }

    public function location()
    {
        return $this->belongsTo('App\Models\CargoLocation','location_id');

    }

    public function driver()
    {
        return $this->hasMany(DriverUser::class,'agent_user_id','id');
    }
}
