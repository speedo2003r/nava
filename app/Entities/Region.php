<?php

namespace App\Entities;

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
 * @property int $city_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Entities\City $City
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Order[] $Orders
 * @property-read int|null $orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Region[] $branches
 * @property-read int|null $branches_count
 * @property-read array $translations
 * @method static \Illuminate\Database\Eloquent\Builder|Region newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Region newQuery()
 * @method static \Illuminate\Database\Query\Builder|Region onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Region query()
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Region withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Region withoutTrashed()
 * @mixin \Eloquent
 */
class Region extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;
    use HasTranslations;

    public $translatable = ['title'];
    protected $fillable = [
        'title',
        'city_id',
    ];
    public function City()
    {
        return $this->belongsTo(City::class);
    }
    public function Orders()
    {
        return $this->hasMany(Order::class);
    }
    public function branches()
    {
        return $this->belongsToMany(Region::class,'branch_regions','region_id','branch_id');
    }

}
