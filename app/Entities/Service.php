<?php

namespace App\Entities;

use App\Models\User;
use App\Entities\RatingService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Spatie\Translatable\HasTranslations;

/**
 * Class Slider.
 *
 * @package namespace App\Entities;
 * @property int $id
 * @property array|null $title
 * @property array|null $description
 * @property int|null $category_id
 * @property float $price
 * @property string|null $image
 * @property string $type
 * @property int $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read array $translations
 * @method static \Illuminate\Database\Eloquent\Builder|Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service newQuery()
 * @method static \Illuminate\Database\Query\Builder|Service onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Service query()
 * @method static \Illuminate\Database\Eloquent\Builder|Service subexist()
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Service withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Service withoutTrashed()
 * @mixin \Eloquent
 */
class Service extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;
    use HasTranslations;

    public $translatable = ['title','description'];
    protected $fillable = [
        'title',
        'description',
        'category_id',
        'price',
        'image',
        'type',
        'active',
    ];

    public function getImageAttribute($value)
    {
        if($value == null){
            return  dashboard_url('images/placeholder.png');
        }
        return  dashboard_url('storage/images/services/'. $value);
    }
    public function scopeSubexist($value)
    {
        return $value->where('active',1);
    }
//    public function ratingService()
//    {
//        return $this->morphOne(RatingService::class,'ratable','rateable_type','rateable_id');
//    }
}
