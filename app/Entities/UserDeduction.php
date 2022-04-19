<?php

namespace App\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Spatie\Translatable\HasTranslations;

/**
 * Class Category.
 *
 * @package namespace App\Entities;
 * @property int $id
 * @property int|null $user_id
 * @property int|null $admin_id
 * @property int|null $order_id
 * @property float $balance
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read User|null $admin
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeduction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeduction newQuery()
 * @method static \Illuminate\Database\Query\Builder|UserDeduction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeduction query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeduction whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeduction whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeduction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeduction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeduction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeduction whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeduction whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeduction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeduction whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|UserDeduction withTrashed()
 * @method static \Illuminate\Database\Query\Builder|UserDeduction withoutTrashed()
 * @mixin \Eloquent
 */
class UserDeduction extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'admin_id',
        'balance',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function admin()
    {
        return $this->belongsTo(User::class,'admin_id');
    }
}
