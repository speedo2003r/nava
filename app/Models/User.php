<?php

namespace App\Models;

use App\Entities\Branch;
use App\Entities\Category;
use App\Entities\City;
use App\Entities\Company;
use App\Entities\Country;
use App\Entities\Device;
use App\Entities\Notification;
use App\Entities\Order;
use App\Entities\OrderGuarantee;
use App\Entities\ReviewRate;
use App\Entities\Service;
use App\Entities\Technician;
use App\Models\Role;
use App\Traits\UploadTrait;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Translatable\HasTranslations;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable,UploadTrait;
    use SoftDeletes,CascadeSoftDeletes;
    use HasTranslations;
    protected $cascadeDeletes = ['technician'];
    public $translatable = ['service_desc','store_name'];

    protected $fillable= [
        'name',
        'avatar',
        'email',
        'wallet',
        'commission_status',
        'income',
        'balance',
        'commission',
        'phone',
        'replace_phone',
        'v_code',
        'password',
        'lang',
        'active',
        'banned',
        'accepted',
        'notify',
        'online',
        'role_id',
        'country_id',
        'city_id',
        'user_type',
        'address',
        'lat',
        'lng',
        'pdf',
        'company_id',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public static function getByDistance($lat, $lng)
    {
        $results = DB::select(DB::raw('SELECT users.id,users.user_type as user_type, ( 3959 * acos( cos( radians(' . $lat . ') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(' . $lng . ') ) + sin( radians(' . $lat .') ) * sin( radians(lat) ) ) ) AS distance FROM users WHERE `user_type` = "provider" ORDER BY distance ASC'));
        return $results;
    }
    public function distance($lat,$lng)
    {
        return (string) round(distance($lat,$lng,$this['lat'],$this['lng']),2);
    }
    public function scopeOlddistance($query, $lat, $lng, $city_id, $unit = "km")
    {

        $unit = ($unit === "km") ? 6378.10 : 3963.17;
        $lat = (float) $lat;
        $lng = (float) $lng;
        $sql =  "($unit * ACOS(COS(RADIANS($lat))
                * COS(RADIANS(lat))
                * COS(RADIANS($lng) - RADIANS(lng))
                + SIN(RADIANS($lat))
                * SIN(RADIANS(lat))))";

        return $query
            ->select(DB::raw("*, $sql AS distance")
            )->orderBy('distance','asc');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function technician()
    {
        return $this->hasOne(Technician::class,'user_id');
    }
    public function technicians()
    {
        return $this->hasMany(User::class,'company_id');
    }
    public function company()
    {
        return $this->hasOne(Company::class,'user_id');
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class,'to_id')->orderByDesc('id');
    }
    public function reviews()
    {
        return $this->morphMany(ReviewRate::class,'rateable','rateable_type','rateable_id');
    }
    public function scopeExist($value)
    {
        return $value->where('active',1)->where('banned',0);
    }
    public function branches(){
        return $this->belongsToMany(Branch::class,'users_branches','user_id','branch_id');
    }
    public function ordersAsUser(){
        return $this->hasMany(Order::class,'user_id','id');
    }
    public function ordersAsTech(){
        return $this->hasMany(Order::class,'technician_id','id');
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class,'order_technicians','technician_id','order_id');
    }
    public function GuaranteeOrders(){
        return $this->hasMany(OrderGuarantee::class,'technical_id','id');
    }
    public function getAvatarAttribute($value)
    {
        if($value == '/default.png' || $value == null){
            return  dashboard_url('images/users/default.png');
        }
        return  dashboard_url('storage/images/users/'. $value);
    }
    public function getBannerAttribute($value)
    {
        if($value == '/default.png' || $value == null){
            return  dashboard_url('images/placeholder.png');
        }
        return  dashboard_url('storage/images/banners/'. $value);
    }


    public function getFullPhoneAttribute()
    {
        # if code update here
        return $this->attributes['phone'];
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class,'user_id');
    }
    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class,'user_categories','user_id','category_id');
    }
    public function refuseOrders()
    {
        return $this->belongsToMany(Order::class,'refuse_orders','user_id','order_id');
    }
}
