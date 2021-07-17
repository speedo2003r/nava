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

}
