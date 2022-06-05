<?php

namespace App\Entities;

use App\Models\Room;
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
 * @property int $id
 * @property string|null $uuid
 * @property string $order_num
 * @property int|null $user_id
 * @property int|null $technician_id
 * @property int|null $city_id
 * @property int|null $region_id
 * @property int|null $category_id
 * @property int $total_services
 * @property int|null $coupon_id
 * @property string|null $coupon_num
 * @property string|null $coupon_type
 * @property float $coupon_amount
 * @property float $vat_per
 * @property float $vat_amount
 * @property float $final_total
 * @property string|null $status
 * @property string|null $cancellation_reason
 * @property int|null $canceled_by
 * @property string $payment_method
 * @property string|null $pay_type
 * @property string $pay_status
 * @property array|null $pay_data
 * @property float $lat
 * @property float $lng
 * @property string $map_desc
 * @property string|null $neighborhood
 * @property string|null $street
 * @property string|null $residence
 * @property string|null $floor
 * @property string|null $address_notes
 * @property string|null $time
 * @property string|null $date
 * @property string|null $notes
 * @property string|null $created_date
 * @property int $estimated_time
 * @property int $progress_start
 * @property int $progress_time
 * @property string|null $progress_end
 * @property string $progress_type
 * @property int $live
 * @property string|null $oper_notes
 * @property int $user_delete
 * @property int $provider_delete
 * @property int $admin_delete
 * @property float $increased_price
 * @property float $increase_tax
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\OrderBill[] $bills
 * @property-read int|null $bills_count
 * @property-read \App\Entities\Category|null $category
 * @property-read \App\Entities\City|null $city
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Image[] $files
 * @property-read int|null $files_count
 * @property-read \App\Entities\OrderGuarantee|null $guarantee
 * @property-read \App\Entities\Income|null $income
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\OrderPart[] $orderParts
 * @property-read int|null $order_parts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\OrderService[] $orderServices
 * @property-read int|null $order_services_count
 * @property-read User|null $provider
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $refuseOrders
 * @property-read int|null $refuse_orders_count
 * @property-read \App\Entities\Region|null $region
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\ReviewRate[] $reviews
 * @property-read int|null $reviews_count
 * @property-read User|null $technician
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $technicians
 * @property-read int|null $technicians_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\OrdersStatus[] $timeLineStatus
 * @property-read int|null $time_line_status_count
 * @property-read User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\UserDeduction[] $userDeductions
 * @property-read int|null $user_deductions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Query\Builder|Order onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereAddressNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereAdminDelete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCanceledBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCancellationReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCouponAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCouponId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCouponNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCouponType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereEstimatedTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereFinalTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereFloor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereIncreaseTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereIncreasedPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereLive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereMapDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereNeighborhood($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOperNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePayData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePayStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePayType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereProgressEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereProgressStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereProgressTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereProgressType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereProviderDelete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereRegionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereResidence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTechnicianId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTotalServices($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserDelete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereVatAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereVatPer($value)
 * @method static \Illuminate\Database\Query\Builder|Order withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Order withoutTrashed()
 * @mixin \Eloquent
 */
class Order extends Model implements Transformable
{
    use TransformableTrait,CascadeSoftDeletes;
    use SoftDeletes;
    protected $cascadeDeletes = ['orderServices'];
    protected $fillable = [
        'uuid',
        'order_num',
        'user_id',
        'technician_id',
        'city_id',
        'region_id',
        'category_id',
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
        'name',
        'phone',
        'email',
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
    public function room(){
        return $this->hasOne(Room::class,'order_id');
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
        $bills = $this->bills()->where('order_bills.status',1)->whereDoesntHave('orderServices')->get();
        if(count($bills) > 0){
            $total += ($bills->sum('price'));
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

        $bills = $this->bills()->where('order_bills.status',1)->whereDoesntHave('orderServices')->get();
        if(count($bills) > 0){
            $tax += ($bills->sum('vat_amount'));
        }
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
    public static function AdminUserStatus($index = null)
    {
        $arr = [
            'pending' => app()->getLocale() == 'ar' ? 'معلق' : 'pending',
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
            'wallet' => app()->getLocale() == 'ar' ? 'محفظه' : 'wallet',
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

    public function timeLineStatus()
    {
        return $this->hasMany(OrdersStatus::class);
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

    public function provider()
    {
        return $this->belongsTo(User::class,'provider_id');
    }

    public function refuseOrders()
    {
        return $this->belongsToMany(User::class,'refuse_orders','order_id','user_id');
    }

}
