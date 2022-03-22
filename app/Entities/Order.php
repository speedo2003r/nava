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
    protected $cascadeDeletes = ['orderServices'];
    protected $fillable = [
        'uuid',
        'user_id',
        'technician_id',
        'city_id',
        'region_id',
        'category_id',
        'subcategory_id',
        'total_services',
        'coupon_id',
        'coupon_num',
        'coupon_type',
        'coupon_amount',
        'vat_per',
        'vat_amount',
        'final_total',
        'status',
        'cancellation_reason',
        'canceled_by',
        'payment_method',
        'pay_type',
        'pay_status',
        'pay_data',
        'lat',
        'lng',
        'map_desc',
        'neighborhood',
        'street',
        'residence',
        'floor',
        'address_notes',
        'time',
        'date',
        'notes',
        'created_date',
        'estimated_time',
        'progress_start',
        'progress_end',
        'progress_type',
        'oper_notes',
        'live',
        'user_delete',
        'provider_delete',
        'admin_delete',
        'increased_price',
        'increase_tax',
    ];

    protected $casts   = [
        'pay_data' => 'array',
    ];
    public function orderServices()
    {
        return $this->hasMany(OrderService::class,'order_id');
    }
    public function orderParts()
    {
        return $this->hasMany(OrderPart::class,'order_id');
    }
    public function income()
    {
        return $this->hasOne(Income::class,'order_id');
    }
    public function guarantee()
    {
        return $this->hasOne(OrderGuarantee::class,'order_id');
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
        $bills = $this->bills()->where('order_bills.status',1)->get();
        if(count($bills) > 0){
            if ($this->coupon_amount > 0) {
                $total = ($this->final_total + $this->vat_amount + ($bills->sum('price') + $bills->sum('vat_amount'))) - $this->coupon_amount;
            } else {
                $total = ($this->final_total + $this->vat_amount + ($bills->sum('price') + $bills->sum('vat_amount')));
            }
        }else{
            if ($this->coupon_amount > 0) {
                $total = ($this->final_total + $this->vat_amount) - $this->coupon_amount;
            } else {
                $total = ($this->final_total + $this->vat_amount);
            }
        }
        return (string) round($total, 2);
    }

    public function totalPrice(){
        $finalTotal = $this->final_total < $this->increased_price ? $this->final_total + $this->increased_price : $this->final_total;
        $tax = $this->final_total < $this->increased_price ? $this->increase_tax + $this->vat_amount : $this->vat_amount;
        $bills = $this->bills()->where('order_bills.status',1)->where('order_bills.pay_type','cash')->get();
        if(count($bills) > 0){
            if ($this->coupon_amount > 0) {
                $total = ($finalTotal + $tax + ($bills->sum('price') + $bills->sum('vat_amount'))) - $this->coupon_amount;
            } else {
                $total = ($finalTotal + $tax + ($bills->sum('price') + $bills->sum('vat_amount')));
            }
        }else{
            if ($this->coupon_amount > 0) {
                $total = ($finalTotal + $tax) - $this->coupon_amount;
            } else {
                $total = ($finalTotal + $tax);
            }
        }
        return (string) round($total, 2);
    }
    public function price()
    {
        $services = $this->orderServices()->where('order_services.status',1)->get();
        $finalTotal = 0;
        if(count($services) > 0){
            foreach ($services as $service){
                $finalTotal += $service['price'] * $service['count'];
            }
        }
        $finalTotal = $this->increased_price > 0 ? $finalTotal + $this->increased_price : $finalTotal;
        $tax = $this->tax();
        if ($this->coupon_amount > 0) {
            $total = ($finalTotal + $tax) - $this->coupon_amount;
        } else {
            $total = ($finalTotal + $tax);
        }
        return (string) round($total, 2);
    }
    public function tax()
    {
        $services = $this->orderServices()->where('order_services.status',1)->get();
        $total = 0;
        $tax = 0;
        if(count($services) > 0){
            foreach ($services as $service){
                $total += $service['price'] * $service['count'];
            }
            $tax = $total * $this['vat_per'] / 100;
        }
        $tax = $this->increased_price > 0 ? $this->increase_tax + $tax : $tax;
        return (string) round($tax, 2);
    }

    public function bills()
    {
        return $this->hasMany(OrderBill::class,'order_id');
    }
    public static function userStatus($index = null)
    {
        $arr = [
            'created' => app()->getLocale() == 'ar' ? 'قيد الفحص' : 'under examination',
            'accepted' => app()->getLocale() == 'ar' ? 'تم قبول الطلب' : 'approved',
            'arrived' => app()->getLocale() == 'ar' ? 'تم الوصول للموقع' : 'arrived',
            'in-progress' => app()->getLocale() == 'ar' ? 'الطلب قيد التنفيذ' : 'in progress',
            'finished' => app()->getLocale() == 'ar' ? 'تم انهاء الطلب' : 'finished',
            'user_cancel' => app()->getLocale() == 'ar' ? 'الطلب ملغي' : 'user cancel order',
        ];
        if($index != null){
            return $arr[$index];
        }
        return $arr;
    }
    public static function userStatusWithBill($index = null)
    {
        $arr = [
            'created' => app()->getLocale() == 'ar' ? 'قيد الفحص' : 'under examination',
            'accepted' => app()->getLocale() == 'ar' ? 'تم قبول الطلب' : 'approved',
            'arrived' => app()->getLocale() == 'ar' ? 'تم الوصول للموقع' : 'arrived',
            'in-progress' => app()->getLocale() == 'ar' ? 'الطلب قيد التنفيذ' : 'in progress',
            'new-invoice' => app()->getLocale() == 'ar' ? 'تم اصدار فاتوره جديده' : 'A new invoice has been issued',
            'finished' => app()->getLocale() == 'ar' ? 'تم انهاء الطلب' : 'finished',
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
            'mada' => app()->getLocale() == 'ar' ? 'مدي' : 'mada',
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
    public function userDeductions()
    {
        return $this->hasMany(UserDeduction::class,'order_id');
    }
    public function technician()
    {
        return $this->belongsTo(User::class,'technician_id');
    }
    public function technicians()
    {
        return $this->belongsToMany(User::class,'order_technicians','order_id','technician_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class,'city_id')->withTrashed();
    }
    public function region()
    {
        return $this->belongsTo(Region::class,'region_id')->withTrashed();
    }
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
    public function subcategory()
    {
        return $this->belongsTo(Category::class,'subcategory_id','id');
    }

    public function provider()
    {
        return $this->belongsTo(User::class,'provider_id');
    }

    public function refuseOrders()
    {
        return $this->belongsToMany(User::class,'refuse_orders','order_id','user_id');
    }
    public static function boot()
    {
        parent::boot();
        $lastId = self::withTrashed()->get()->last()->id ?? 0;
        $d = (int) (date('Y') . $lastId) + 1;
        self::creating(function($model) use ($d){
            $model->order_num = $d;
        });
    }

}
