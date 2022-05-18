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
 * @property int|null $user_id
 * @property string|null $title
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $message
 * @property string|null $seen
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint newQuery()
 * @method static \Illuminate\Database\Query\Builder|Complaint onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint query()
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint whereSeen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Complaint withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Complaint withoutTrashed()
 * @mixin \Eloquent
 */
class Complaint extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;

    protected $table = 'complaints';
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
