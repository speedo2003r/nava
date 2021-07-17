<?php

namespace App\Entities;

use App\Entities\City;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Spatie\Translatable\HasTranslations;

/**
 * Class Country.
 *
 * @package namespace App\Entities;
 */
class Country extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;
    use HasTranslations;

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
