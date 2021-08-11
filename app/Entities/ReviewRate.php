<?php

namespace App\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ReviewRate.
 *
 * @package namespace App\Entities;
 */
class ReviewRate extends Model implements Transformable
{
    use TransformableTrait;
    public $fillable = [
        'user_id',
        'order_id',
        'rateable_id',
        'rateable_type',
        'rate',
        'comment',
        'status',
    ];

    public function rateable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
