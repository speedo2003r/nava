<?php

namespace App\Entities;

use App\Models\User;
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
 * @property string $title
 * @property string|null $image
 * @property int|null $city_id
 * @property int $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $category_id
 * @property int|null $sub_category_id
 * @property-read \App\Entities\Category|null $category
 * @property-read \App\Entities\City|null $city
 * @property-read \App\Entities\Category|null $subcategory
 * @method static \Illuminate\Database\Eloquent\Builder|Slider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider newQuery()
 * @method static \Illuminate\Database\Query\Builder|Slider onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider query()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereSubCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Slider withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Slider withoutTrashed()
 * @mixin \Eloquent
 */
class Slider extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'city_id',
        'image',
        'category_id',
        'sub_category_id',
        'active',
    ];
    public function getImageAttribute()
    {
        return dashboard_url('storage/images/sliders/'.$this->attributes['image']);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
    public function subcategory()
    {
        return $this->belongsTo(Category::class,'sub_category_id');
    }

}
