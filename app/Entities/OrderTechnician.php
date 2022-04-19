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
 * @property int $technician_id
 * @property int $order_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OrderTechnician newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderTechnician newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderTechnician query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderTechnician whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderTechnician whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderTechnician whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderTechnician whereTechnicianId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderTechnician whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderTechnician extends Model implements Transformable
{
    use TransformableTrait;
    protected $fillable = [
        'technician_id',
        'order_id',
    ];

}
