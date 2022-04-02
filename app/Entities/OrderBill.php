<?php

namespace App\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Spatie\Translatable\HasTranslations;

/**
 * Class Order.
 *
 * @package namespace App\Entities;
 */
class OrderBill extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;
    protected $fillable = [
        'order_id',
        'text',
        'price',
        'vat_per',
        'vat_amount',
        'coupon_id',
        'coupon_num',
        'coupon_amount',
        'payment_method',
        'pay_type',
        'pay_status',
        'pay_data',
        'type',
        'status',
        'refuse_reason',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }

    public function _price()
    {
        return ($this->price + $this->vat_amount);
    }
    public function orderParts()
    {
        return $this->belongsToMany(OrderPart::class,'order_parts_bills','order_bill_id','order_part_id');
    }
    public function orderServices()
    {
        return $this->belongsToMany(OrderService::class,'order_services_bills','order_bill_id','order_service_id');
    }
}
