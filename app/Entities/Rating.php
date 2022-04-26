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
 * @property int $id
 * @property int $user_id
 * @property int $order_id
 * @property string $rateable_type
 * @property int $rateable_id
 * @property int $rate
 * @property string|null $comment
 * @property int $status
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property string|null $deleted_at
 * @property-read Model|\Eloquent $rateable
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|ReviewRate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReviewRate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReviewRate query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReviewRate whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReviewRate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReviewRate whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReviewRate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReviewRate whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReviewRate whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReviewRate whereRateableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReviewRate whereRateableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReviewRate whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReviewRate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReviewRate whereUserId($value)
 * @mixin \Eloquent
 */
class Rating extends Model implements Transformable
{
    use TransformableTrait;
    public $fillable = [
        'rateable_id',
        'rateable_type',
        'rate',
        'followers',
    ];

    public function rateable()
    {
        return $this->morphTo();
    }

}
