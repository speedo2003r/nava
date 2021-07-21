<?php

namespace App\Entities;

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

}
