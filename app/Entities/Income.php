<?php

namespace App\Entities;

use App\Models\User;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Order.
 *
 * @package namespace App\Entities;
 */
class Income extends Model implements Transformable
{
    use TransformableTrait,CascadeSoftDeletes;
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'order_id',
        'income',
        'debtor',
        'creditor',
        'type',
        'status',
    ];


    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
