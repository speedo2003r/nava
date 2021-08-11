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
class OrderService extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;
    use HasTranslations;
    public $translatable = ['title'];
    protected $fillable = [
        'title',
        'order_id',
        'service_id',
        'count',
        'price',
        'status',
        'type',
    ];

    public static function serviceType($value = null)
    {
        $arr = [
            'hourly' => 'بالساعه',
            'fixed' => 'ثابت',
            'pricing' => 'تقديري',
        ];
        if($value != null){
            return $arr[$value];
        }
        return $arr;
    }
    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }
    public function service()
    {
        return $this->belongsTo(Service::class,'service_id');
    }
}
