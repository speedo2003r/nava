<?php

namespace App\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Device.
 *
 * @package namespace App\Entities;
 */
class Device extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'uuid',
        'device_id',
        'device_type',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
