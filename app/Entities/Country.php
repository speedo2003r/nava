<?php

namespace App\Entities;

use App\Entities\City;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Spatie\Translatable\HasTranslations;

/**
 * Class Country.
 *
 * @package namespace App\Entities;
 * @property int $id
 * @property array $title
 * @property string|null $code
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|City[] $Cities
 * @property-read int|null $cities_count
 * @property-read array $translations
 * @method static \Illuminate\Database\Eloquent\Builder|Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country newQuery()
 * @method static \Illuminate\Database\Query\Builder|Country onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Country query()
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Country withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Country withoutTrashed()
 * @mixin \Eloquent
 */
class Country extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes,CascadeSoftDeletes;
    use HasTranslations;
    protected $cascadeDeletes = ['Cities'];

    public $translatable = ['title'];
    protected $fillable = [
        'title',
        'code',
    ];
    protected $with = ['Cities'];

    public function Cities()
    {
        return $this->hasMany(City::class,'country_id');
    }

}
