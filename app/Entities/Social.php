<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Social.
 *
 * @package namespace App\Entities;
 */
class Social extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'key',
        'value',
    ];


}
