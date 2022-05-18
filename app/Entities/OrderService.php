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
 * @property int|null $service_id
 * @property int|null $category_id
 * @property array|null $title
 * @property int $count
 * @property int $preview_request
 * @property float|null $price
 * @property float|null $tax
 * @property int $status
 * @property string|null $type
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\OrderBill[] $bills
 * @property-read int|null $bills_count
 * @property-read \App\Entities\Category|null $category
 * @property-read array $translations
 * @property-read \App\Entities\Order|null $order
 * @property-read \App\Entities\Service|null $service
 * @method static \Illuminate\Database\Eloquent\Builder|OrderService newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderService newQuery()
 * @method static \Illuminate\Database\Query\Builder|OrderService onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderService query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderService whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderService whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderService whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderService whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderService whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderService whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderService wherePreviewRequest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderService wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderService whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderService whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderService whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderService whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderService whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderService whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|OrderService withTrashed()
 * @method static \Illuminate\Database\Query\Builder|OrderService withoutTrashed()
 * @mixin \Eloquent
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
        'category_id',
        'count',
        'preview_request',
        'price',
        'tax',
        'status',
        'type',
    ];

    public static function serviceType($value = null)
    {
        $arr = [
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
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
    public function service()
    {
        return $this->belongsTo(Service::class,'service_id');
    }

    public function bills()
    {
        return $this->belongsToMany(OrderBill::class,'order_services_bills','order_service_id','order_bill_id');
    }
}
