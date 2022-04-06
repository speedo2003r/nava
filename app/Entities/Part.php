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
class Part extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;
    use HasTranslations;

    public $translatable = ['title','description'];
    protected $fillable = [
        'title',
        'description',
        'service_id',
        'price',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
