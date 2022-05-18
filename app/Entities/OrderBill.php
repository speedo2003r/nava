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
 * @property int $id
 * @property int $order_id
 * @property string|null $text
 * @property float|null $price
 * @property float $vat_per
 * @property float $vat_amount
 * @property string $payment_method
 * @property int|null $coupon_id
 * @property string|null $coupon_num
 * @property float $coupon_amount
 * @property string|null $pay_type
 * @property string $pay_status
 * @property string|null $pay_data
 * @property string|null $type
 * @property int|null $status
 * @property string|null $refuse_reason
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Entities\Order $order
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\OrderPart[] $orderParts
 * @property-read int|null $order_parts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\OrderService[] $orderServices
 * @property-read int|null $order_services_count
 * @method static \Illuminate\Database\Eloquent\Builder|OrderBill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderBill newQuery()
 * @method static \Illuminate\Database\Query\Builder|OrderBill onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderBill query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderBill whereCouponAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderBill whereCouponId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderBill whereCouponNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderBill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderBill whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderBill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderBill whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderBill wherePayData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderBill wherePayStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderBill wherePayType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderBill wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderBill wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderBill whereRefuseReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderBill whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderBill whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderBill whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderBill whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderBill whereVatAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderBill whereVatPer($value)
 * @method static \Illuminate\Database\Query\Builder|OrderBill withTrashed()
 * @method static \Illuminate\Database\Query\Builder|OrderBill withoutTrashed()
 * @mixin \Eloquent
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
