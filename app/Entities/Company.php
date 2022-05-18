<?php

namespace App\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Spatie\Translatable\HasTranslations;

/**
 * Class Category.
 *
 * @package namespace App\Entities;
 * @property int $id
 * @property string|null $manager_name
 * @property string|null $id_number رقم البطاقه
 * @property string|null $commercial_num
 * @property string|null $acc_bank حساب بنكي
 * @property string|null $commercial_image سجل الشركه التجاري
 * @property string|null $tax_certificate الشهاده الضريبيه
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read mixed $id_avatar
 * @property-read array $translations
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company newQuery()
 * @method static \Illuminate\Database\Query\Builder|Company onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereAccBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCommercialImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCommercialNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereIdNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereManagerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereTaxCertificate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Company withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Company withoutTrashed()
 * @mixin \Eloquent
 */
class Company extends Model implements Transformable
{
    use TransformableTrait;
    use HasTranslations;
    use SoftDeletes;

    public $translatable = ['title'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'manager_name',
        'id_number',
        'commercial_num',
        'acc_bank',
        'commercial_image',
        'tax_certificate',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function getCommercialImageAttribute($value)
    {
        if($value == null){
            return  dashboard_url('images/placeholder.png');
        }
        return  dashboard_url('storage/images/companies/'. $value);
    }
    public function getTaxCertificateAttribute($value)
    {
        if($value == null){
            return  dashboard_url('images/placeholder.png');
        }
        return  dashboard_url('storage/images/companies/'. $value);
    }
    public function getIdAvatarAttribute($value)
    {
        if($value == null){
            return  dashboard_url('images/placeholder.png');
        }
        return  dashboard_url('storage/images/companies/'. $value);
    }
}
