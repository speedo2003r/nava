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
