<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Activitylog\ActivitylogServiceProvider;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;


class Order extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Order')
            ->logAll()
            ->logOnlyDirty()
            ->logExcept(['updated_at','created_at'])
            ->dontSubmitEmptyLogs();

    }

    protected $casts = [
        'email' => 'array',
    ];

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
        'invoice_number',
        'client_hwb',
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
        return $this->hasMany(Cargo::class);

    }

    public function tracker()
    {
        return $this->hasMany(Tracker::class);

    }

    public function cargolocation()
    {
        return $this->belongsTo(CargoLocation::class, 'cargo_location_id');

    }
    public function shipper_city()
    {
        return $this->belongsTo(CargoLocation::class, 'shipper_address_id');

    }
    public function consignee_city()
    {
        return $this->belongsTo(CargoLocation::class, 'consignee_address_id');

    }
    public function status()
    {
        return $this->belongsTo(ProductStatus::class, 'status_id');

    }

    public function payer()
    {
        return $this->belongsTo(Payer::class, 'payer_id');

    }

    public function substatus()
    {
        return $this->belongsTo(SubProductStatus::class, 'substatus_id');

    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class,'order_id','id');
    }

}
