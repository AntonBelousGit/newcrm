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
        return $this->hasMany(User::class,'driver_id','id');

    }
    public function agent()
    {
        return $this->belongsTo(AgentUser::class,'agent_user_id');
    }
}
