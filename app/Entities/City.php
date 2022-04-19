<?php

namespace App\Entities;

use App\Models\User;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Spatie\Translatable\HasTranslations;

/**
 * Class City.
 *
 * @package namespace App\Entities;
 * @property int $id
 * @property array|null $title
 * @property int $country_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Entities\Country $Country
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Region[] $Regions
 * @property-read int|null $regions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Branch[] $branches
 * @property-read int|null $branches_count
 * @property-read array $translations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Order[] $orders
 * @property-read int|null $orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $technicians
 * @property-read int|null $technicians_count
 * @method static \Illuminate\Database\Eloquent\Builder|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City newQuery()
 * @method static \Illuminate\Database\Query\Builder|City onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|City query()
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|City withTrashed()
 * @method static \Illuminate\Database\Query\Builder|City withoutTrashed()
 * @mixin \Eloquent
 */
class City extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes,CascadeSoftDeletes;
    use HasTranslations;
    protected $cascadeDeletes = ['Regions'];

    public $translatable = ['title'];
    protected $fillable = [
        'title',
        'country_id',
    ];
    public function Country()
    {
        return $this->belongsTo(Country::class);
    }
    public function Regions()
    {
        return $this->hasMany(Region::class);
    }
    public function branches()
    {
        return $this->hasMany(Branch::class,'city_id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function technicians()
    {
        return $this->hasMany(User::class)->whereIn('user_type',['company','technician'])->whereDoesntHave('company');
    }

}
