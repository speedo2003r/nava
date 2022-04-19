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
 * @property int $id
 * @property int|null $order_id
 * @property int|null $technical_id
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int $status
 * @property int $solved
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Entities\Order|null $order
 * @property-read User|null $technical
 * @method static \Illuminate\Database\Eloquent\Builder|OrderGuarantee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderGuarantee newQuery()
 * @method static \Illuminate\Database\Query\Builder|OrderGuarantee onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderGuarantee query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderGuarantee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderGuarantee whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderGuarantee whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderGuarantee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderGuarantee whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderGuarantee whereSolved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderGuarantee whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderGuarantee whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderGuarantee whereTechnicalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderGuarantee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|OrderGuarantee withTrashed()
 * @method static \Illuminate\Database\Query\Builder|OrderGuarantee withoutTrashed()
 * @mixin \Eloquent
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
