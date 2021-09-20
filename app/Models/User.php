<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use HasFactory, Notifiable, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = [ 'updated_at','created_at' ];
    protected static $submitEmptyLogs = false;


    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }

    public function hasRole($role){
        if($this->roles()->where('name',$role)->first()){
            return true;
        }
        return false;
    }
    public function driver()
    {
        return $this->belongsTo('App\Models\DriverUser','driver_id');

    }
    public function agent()
    {
        return $this->belongsTo('App\Models\AgentUser','agent_id');

    }
    public function getpayer()
    {
        return $this->belongsTo('App\Models\Payer','payer_id');

    }
    public function payer()
    {
        return $this->belongsToMany(
            Payer::class,
            'payer_user',
            'user_id',
            'payer_id'
        );
    }
}
