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
 * @property int|null $order_id
 * @property array|null $title
 * @property int $count
 * @property float $price
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read array $translations
 * @property-read \App\Entities\Order|null $order
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\OrderBill[] $orderBills
 * @property-read int|null $order_bills_count
 * @property-read \App\Entities\Part|null $part
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPart newQuery()
 * @method static \Illuminate\Database\Query\Builder|OrderPart onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPart query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPart whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPart whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPart whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPart wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPart whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPart whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|OrderPart withTrashed()
 * @method static \Illuminate\Database\Query\Builder|OrderPart withoutTrashed()
 * @mixin \Eloquent
 */
class OrderPart extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;
    use HasTranslations;
    public $translatable = ['title'];
    protected $fillable = [
        'title',
        'order_id',
        'count',
        'price',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }
    public function part()
    {
        return $this->belongsTo(Part::class,'part_id');
    }

    public function orderBills()
    {
        return $this->belongsToMany(OrderBill::class,'order_parts_bills','order_part_id','order_bill_id');
    }
    public function _price()
    {
        return $this->price * $this->count;
    }
}
