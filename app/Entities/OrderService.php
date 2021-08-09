<?php

namespace App\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Order.
 *
 * @package namespace App\Entities;
 */
class OrderService extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;
    protected $fillable = [
        'order_id',
        'service_id',
        'count',
        'price',
        'status',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }
    public function service()
    {
        return $this->belongsTo(Service::class,'service_id');
    }
}
