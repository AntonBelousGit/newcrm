<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipper',
        'phone_shipper',
        'address_shipper',
        'company_shipper',
        'consignee',
        'phone_consignee',
        'address_consignee',
        'company_consignee',
        'shipment_description',
        'comment',
        'sending_time',
        'delivery_time',
        'sensor_for_rent',
        'container',
        'return_sensor',
        'return_container',
        'delivery_comment',
        'notifications',
        'user_id',
        'number_order',
        'invoice_number'
    ];

//    public function cargo()
//    {
//        return $this->belongsToMany(
//            Cargo::class,
//            'cargos',
//            'order_id'
//        );
//
//    }
    public function cargo()
    {
        return $this->hasMany('App\Models\Cargo');

    }

    public function tracker()
    {
        return $this->hasMany('App\Models\Tracker');

    }

    public function cargolocation()
    {
        return $this->belongsTo('App\Models\CargoLocation', 'cargo_location_id');

    }
    public function shipper_city()
    {
        return $this->belongsTo('App\Models\CargoLocation', 'shipper_address_id');

    }
    public function consignee_city()
    {
        return $this->belongsTo('App\Models\CargoLocation', 'consignee_address_id');

    }
    public function status()
    {
        return $this->belongsTo('App\Models\ProductStatus', 'status_id');

    }

    public function payer()
    {
        return $this->belongsTo('App\Models\Payer', 'payer_id');

    }

    public function substatus()
    {
        return $this->belongsTo('App\Models\SubProductStatus', 'substatus_id');

    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function agent()
    {
        return $this->belongsTo('App\Models\User', 'agent_id');
    }

    public function driver()
    {
        return $this->belongsTo('App\Models\User', 'driver_id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class,'order_id','id');
    }

}
