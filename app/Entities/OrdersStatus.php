<?php

namespace App\Entities;

use App\Models\User;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Spatie\Translatable\HasTranslations;

/**
 * Class City.
 *
 * @package namespace App\Entities;
 * @property int $id
 * @property int $order_id
 * @property int|null $order_bill_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Entities\Order $order
 * @property-read \App\Entities\OrderBill|null $orderBill
 * @method static \Illuminate\Database\Eloquent\Builder|OrdersStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrdersStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrdersStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrdersStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrdersStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrdersStatus whereOrderBillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrdersStatus whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrdersStatus whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrdersStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrdersStatus extends Model implements Transformable
{
    use TransformableTrait;
    protected $table = 'orders_status';
    protected $casts = [
        'created_at' => 'datetime',
    ];
    protected $fillable = [
        'order_id',
        'order_bill_id',
        'status',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function orderBill()
    {
        return $this->belongsTo(OrderBill::class);
    }

}
