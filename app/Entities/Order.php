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
        'provider_id',
        'lat',
        'lng',
        'map_desc',
        'total_items',
        'vat_per',
        'vat_amount',
        'shipping_price',
        'final_total',
        'commission',
        'status',
        'category_id',
        'subcategory_id',
        'pay_type',
        'pay_status',
        'pay_data',
        'finished_date',
        'time',
        'date',
        'notes',
        'contract',
        'contract_approved',
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
    public function _price()
    {
        $total = ( (string) round($this->vat_amount,2) + $this->final_total);
        return (string) round($total,2);
    }

    public static function userStatus($index = null)
    {
        $arr = [
            'confirmed' => app()->getLocale() == 'ar' ? 'وضع الانتظار' : 'standby mode',
            'approved' => app()->getLocale() == 'ar' ? 'مقبول' : 'approved',
            'under_work' => app()->getLocale() == 'ar' ? 'تحت التنفيذ' : 'Under implementation',
            'done' => app()->getLocale() == 'ar' ? 'تم التنفيذ' : 'done',
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
