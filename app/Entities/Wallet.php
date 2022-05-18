<?php

namespace App\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Visit.
 *
 * @package namespace App\Entities;
 * @property int $id
 * @property string $device_type
 * @property string|null $city_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Visit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Visit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Visit query()
 * @method static \Illuminate\Database\Eloquent\Builder|Visit whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Visit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Visit whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Visit whereDeviceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Visit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Visit whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read User|null $createdBy
 * @property-read \App\Entities\Order $order
 * @property-read User $user
 * @method static \Illuminate\Database\Query\Builder|Wallet onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|Wallet withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Wallet withoutTrashed()
 * @property float $amount
 * @property string|null $type
 * @property string|null $expire_date
 * @property int $user_id
 * @property int|null $order_id
 * @property int|null $created_by
 * @property int $confirmed
 * @property string $operation_type
 * @property string|null $pay_data
 * @property string|null $pay_type
 * @property string|null $pay_status
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereExpireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereOperationType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet wherePayData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet wherePayStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet wherePayType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereUserId($value)
 */
class Wallet extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount',
        'type',
        'expire_date',
        'user_id',
        'order_id',
        'created_by',
        'confirmed',
        'operation_type',
        'pay_data',
        'pay_type',
        'pay_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class,'created_by');
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
