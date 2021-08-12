<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Spatie\Translatable\HasTranslations;

/**
 * Class Question.
 *
 * @package namespace App\Entities;
 */
class Question extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;
    use HasTranslations;

    public $translatable = ['key','value'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'value',
    ];

}
