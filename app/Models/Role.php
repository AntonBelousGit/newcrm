<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Role extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Role')
            ->logOnly(['*','users'])
            ->logExcept(['updated_at','created_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }


    public function users(){
        return $this->belongsToMany('App\Models\User');
    }
}
