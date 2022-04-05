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
