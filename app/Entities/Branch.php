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
 * @property array|null $title
 * @property int $assign_deadline
 * @property int|null $city_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Entities\City|null $city
 * @property-read array $translations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Region[] $regions
 * @property-read int|null $regions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Branch newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Branch newQuery()
 * @method static \Illuminate\Database\Query\Builder|Branch onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Branch query()
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereAssignDeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Branch withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Branch withoutTrashed()
 * @mixin \Eloquent
 */
class Branch extends Model implements Transformable
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
        'title',
        'assign_deadline',
        'city_id',
    ];
    public function city()
    {
        return $this->belongsTo(City::class,'city_id');
    }
    public function regions()
    {
        return $this->belongsToMany(Region::class,'branch_regions','branch_id','region_id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class,'users_branches','branch_id','user_id');
    }
}
