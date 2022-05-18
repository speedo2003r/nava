<?php

namespace App\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ContactUs.
 *
 * @package namespace App\Entities;
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $phone
 * @property string $message
 * @property int $seen
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs newQuery()
 * @method static \Illuminate\Database\Query\Builder|ContactUs onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs whereSeen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactUs whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|ContactUs withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ContactUs withoutTrashed()
 * @mixin \Eloquent
 */
class ContactUs extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;

    protected $table = 'contacts';
    protected $fillable = [
        'name',
        'title',
        'email',
        'phone',
        'message',
        'seen',
        'user_id', // sometimes nullable
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
