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
class OrderPart extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;
    use HasTranslations;
    public $translatable = ['title'];
    protected $fillable = [
        'title',
        'order_id',
        'part_id',
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

    public function _price()
    {
        return $this->price * $this->count;
    }
}
