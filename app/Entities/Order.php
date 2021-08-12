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
class Order extends Model implements Transformable
{
    use TransformableTrait,CascadeSoftDeletes;
    use SoftDeletes;
    protected $cascadeDeletes = ['OrderInstallments','orderServices'];
    protected $fillable = [
        'order_num',
        'user_id',
        'technician_id',
        'region_id',
        'category_id',
//        'branch_id',
        'subscription_id',
        'total_services',
        'coupon_id',
        'coupon_num',
        'coupon_type',
        'coupon_amount',
        'vat_per',
        'vat_amount',
        'final_total',
        'status',
        'cycle',
        'cancellation_reason',
        'canceled_by',
        'payment_method',
        'pay_type',
        'pay_status',
        'pay_data',
        'lat',
        'lng',
        'map_desc',
        'street',
        'residence',
        'floor',
        'address_notes',
        'time',
        'date',
        'notes',
        'estimated_time',
        'progress_start',
        'progress_time',
        'progress_type',
        'live',
        'user_delete',
        'provider_delete',
        'admin_delete',
    ];

    protected $casts   = [
        'pay_data' => 'array',
    ];

    public function orderInstallments()
    {
        return $this->hasMany(OrderInstallment::class,'order_id');
    }
    public function orderServices()
    {
        return $this->hasMany(OrderService::class,'order_id');
    }
    public function orderParts()
    {
        return $this->hasMany(OrderPart::class,'order_id');
    }
    public function reviews()
    {
        return $this->hasMany(ReviewRate::class,'order_id');
    }
    public function files()
    {
        return $this->morphMany(Image::class,'imageable','image_type','image_id');
    }
    public function _price()
    {
        $orderServices = $this->orderServices()->where('status',1)->sum('price');

        $total = ($orderServices);
        return (string) round($total,2);
    }

    public static function userStatus($index = null)
    {
        $arr = [
            'created' => app()->getLocale() == 'ar' ? 'قيد الفحص' : 'under examination',
            'accepted' => app()->getLocale() == 'ar' ? 'تم القبول' : 'approved',
            'on-way' => app()->getLocale() == 'ar' ? 'في الطريق' : 'on way',
            'arrived' => app()->getLocale() == 'ar' ? 'تم الوصول' : 'arrived',
            'in-progress' => app()->getLocale() == 'ar' ? 'قيد التنفيذ' : 'in progress',
            'finished' => app()->getLocale() == 'ar' ? 'تم الانتهاء' : 'finished',
            'canceled' => app()->getLocale() == 'ar' ? 'تم الالغاء' : 'canceled',
            'rejected' => app()->getLocale() == 'ar' ? 'تم الرفض' : 'rejected',
        ];
        if($index != null){
            return $arr[$index];
        }
        return $arr;
    }
    public static function orderMethods($index = null)
    {
        $arr = [
            'cash' => app()->getLocale() == 'ar' ? 'كاش' : 'cash',
            'visa' => app()->getLocale() == 'ar' ? 'فيزا كارد' : 'visa card',
            'master' => app()->getLocale() == 'ar' ? 'ماستر كارد' : 'master card',
            'apple' => app()->getLocale() == 'ar' ? 'أبل' : 'apple pay',
            'stc' => app()->getLocale() == 'ar' ? 'stc دفع' : 'stc pay',
        ];
        if($index != null){
            return $arr[$index];
        }
        return $arr;
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function technician()
    {
        return $this->belongsTo(User::class,'technician_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
    public function subcategory()
    {
        return $this->belongsTo(Category::class,'subcategory_id');
    }

    public function provider()
    {
        return $this->belongsTo(User::class,'provider_id');
    }

    public static function boot()
    {
        parent::boot();
        $lastId = self::all()->last()->id ?? 0;
        $d = (int) (date('Y') . $lastId) + 1;
        self::creating(function($model) use ($d){
            $model->order_num = $d;
        });
    }

}
