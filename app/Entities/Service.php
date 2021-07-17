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
