<?php

namespace App\Models;

use App\Entities\Branch;
use App\Entities\Category;
use App\Entities\City;
use App\Entities\Company;
use App\Entities\Country;
use App\Entities\Device;
use App\Entities\Order;
use App\Entities\OrderGuarantee;
use App\Entities\Rating;
use App\Entities\ReviewRate;
use App\Entities\Service;
use App\Entities\Technician;
use App\Entities\Wallet;
use App\Enum\OrderStatus;
use App\Enum\WalletOperationType;
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

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $avatar
 * @property string|null $email
 * @property int $commission_status
 * @property float|null $income
 * @property int|null $commission
 * @property string $phone
 * @property string|null $replace_phone
 * @property string|null $v_code
 * @property string $password
 * @property string $lang
 * @property int $active mobile activation
 * @property int $banned
 * @property int $accepted Admin approval
 * @property int $notify
 * @property int $online
 * @property int|null $role_id
 * @property int|null $country_id
 * @property int|null $city_id
 * @property string $user_type
 * @property string|null $address
 * @property string|null $lat
 * @property string|null $lng
 * @property string|null $pdf
 * @property int|null $socket_id
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $company_id
 * @property-read \Illuminate\Database\Eloquent\Collection|OrderGuarantee[] $GuaranteeOrders
 * @property-read int|null $guarantee_orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Branch[] $branches
 * @property-read int|null $branches_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Category[] $categories
 * @property-read int|null $categories_count
 * @property-read Category $category
 * @property-read City|null $city
 * @property-read Company|null $company
 * @property-read Country|null $country
 * @property-read \Illuminate\Database\Eloquent\Collection|Device[] $devices
 * @property-read int|null $devices_count
 * @property-read mixed $banner
 * @property-read mixed $full_phone
 * @property-read mixed $progress_orders_count
 * @property-read array $translations
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Order[] $orders
 * @property-read int|null $orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Order[] $ordersAsTech
 * @property-read int|null $orders_as_tech_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Order[] $ordersAsUser
 * @property-read int|null $orders_as_user_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Order[] $refuseOrders
 * @property-read int|null $refuse_orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection|ReviewRate[] $reviews
 * @property-read int|null $reviews_count
 * @property-read Role|null $role
 * @property-read \Illuminate\Database\Eloquent\Collection|Service[] $services
 * @property-read int|null $services_count
 * @property-read Technician|null $technician
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $technicians
 * @property-read int|null $technicians_count
 * @method static \Illuminate\Database\Eloquent\Builder|User exist()
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User olddistance($lat, $lng, $city_id, $unit = 'km')
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAccepted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBanned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCommissionStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNotify($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereOnline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePdf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereReplacePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSocketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereVCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereWallet($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 * @mixin \Eloquent
 * @property int $max_dept
 * @property int $chat
 * @property-read mixed $wallet
 * @property-read Rating|null $rating
 * @property-read \Illuminate\Database\Eloquent\Collection|Wallet[] $wallets
 * @property-read int|null $wallets_count
 * @method static \Illuminate\Database\Eloquent\Builder|User whereChat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMaxDept($value)
 */
class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable,UploadTrait;
    use SoftDeletes,CascadeSoftDeletes;
    use HasTranslations;
    protected $appends = ['wallet'];
    protected $cascadeDeletes = ['technician'];
    public $translatable = ['service_desc','store_name'];

    protected $fillable= [
        'name',
        'avatar',
        'email',
        'commission_status',
        'income',
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
        'max_dept',
        'chat',
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

    public function getWalletAttribute()
    {
        $deposit = $this->wallets()->where('operation_type',WalletOperationType::DEPOSIT)->sum('amount');
        $withdrawal = $this->wallets()->where('operation_type',WalletOperationType::WITHDRAWAL)->sum('amount');
        return number_format($deposit - $withdrawal,2);
    }
    public function wallets()
    {
        return $this->hasMany(Wallet::class,'user_id');
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
    public function reviews()
    {
        return $this->morphMany(ReviewRate::class,'rateable','rateable_type','rateable_id');
    }
    public function rating()
    {
        return $this->morphOne(Rating::class,'rateable','rateable_type','rateable_id');
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

    public function getProgressOrdersCountAttribute($value)
    {
        return $this->ordersAsTech()->whereIn('status',[OrderStatus::ACCEPTED,OrderStatus::ARRIVED,OrderStatus::INPROGRESS,OrderStatus::ONWAY])->count();
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
