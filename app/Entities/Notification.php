<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Spatie\Translatable\HasTranslations;

/**
 * Class Notification.
 *
 * @package namespace App\Entities;
 */
class Notification extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;
    use HasTranslations;

    public $translatable = ['title'];
    protected $fillable = [
        'to_id',
        'from_id',
        'message',
        'type',
        'type_id',
        'seen',
    ];

    public function getMessageAttribute()
    {
        $attr = 'message_' . app()->getLocale();
        return $this->attributes[$attr];
    }

    public function From()
    {
        return $this->belongsTo('App\Models\User','from_id');
    }

}
