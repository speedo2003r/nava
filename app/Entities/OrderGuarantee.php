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
class OrderGuarantee extends Model implements Transformable
{
    use TransformableTrait,CascadeSoftDeletes;
    use SoftDeletes;
    protected $fillable = [
        'order_id',
        'start_date',
        'end_date',
        'status',
        'solved',
        'technical_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }
    public function technical()
    {
        return $this->belongsTo(User::class,'technical_id');
    }



}
