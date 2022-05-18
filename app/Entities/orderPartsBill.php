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
 * @property int $order_bill_id
 * @property int $order_part_id
 * @method static \Illuminate\Database\Eloquent\Builder|orderPartsBill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|orderPartsBill newQuery()
 * @method static \Illuminate\Database\Query\Builder|orderPartsBill onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|orderPartsBill query()
 * @method static \Illuminate\Database\Eloquent\Builder|orderPartsBill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|orderPartsBill whereOrderBillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|orderPartsBill whereOrderPartId($value)
 * @method static \Illuminate\Database\Query\Builder|orderPartsBill withTrashed()
 * @method static \Illuminate\Database\Query\Builder|orderPartsBill withoutTrashed()
 * @mixin \Eloquent
 */
class orderPartsBill extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;
    protected $fillable = [
        'order_bill_id',
        'order_part_id',
    ];
}
