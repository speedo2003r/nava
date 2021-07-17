<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Spatie\Translatable\HasTranslations;

/**
 * Class Page.
 *
 * @package namespace App\Entities;
 */
class Page extends Model implements Transformable
{
    use TransformableTrait;
    use HasTranslations;
    use SoftDeletes;

    public $translatable = ['title','desc'];

    protected $fillable = [
        'title',
        'desc',
    ];


    public static function getAboutApp(): Page
    {
        return Page::find(1);
    }
    public static function getPoliciesApp(): Page
    {
        return Page::find(2);
    }

}
