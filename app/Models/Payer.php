<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payer extends Model
{
    use HasFactory;


    public function user()
    {
        return $this->belongsToMany(
            User::class,
            'payer_user',
            'user_id',
            'payer_id'
        );
    }
}
