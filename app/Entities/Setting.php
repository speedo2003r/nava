<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Setting.
 *
 * @package namespace App\Entities;
 */
class Setting extends Model implements Transformable
{
    use TransformableTrait;


    protected $fillable = [
        'key',
        'value',
    ];

}
