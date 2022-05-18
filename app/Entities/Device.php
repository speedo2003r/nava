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
 * @property int $id
 * @property string|null $uuid
 * @property string|null $device_id
 * @property string|null $device_type
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Device newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Device newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Device query()
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereDeviceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereUuid($value)
 * @mixin \Eloquent
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
