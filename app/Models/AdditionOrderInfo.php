<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionOrderInfo extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'additional_shipper_contact','additional_consignee_contact','direct_to_person'];

    public  function order()
    {
        $this->belongsTo(Order::class,'order_id');
    }
}
