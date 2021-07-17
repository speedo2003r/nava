<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Image.
 *
 * @package namespace App\Entities;
 */
class Image extends Model implements Transformable
{
    use TransformableTrait;

    use SoftDeletes;
    public $fillable = [
        'image_id',
        'image_type',
        'image'
    ];
    public function imageable()
    {
        return $this->morphTo();
    }

}
