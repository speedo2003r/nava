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
 */
class Slider extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'city_id',
        'image',
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

}
