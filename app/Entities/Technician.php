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
 * @property string|null $bank_acc_id
 * @property string|null $id_number
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Technician newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Technician newQuery()
 * @method static \Illuminate\Database\Query\Builder|Technician onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Technician query()
 * @method static \Illuminate\Database\Eloquent\Builder|Technician whereBankAccId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Technician whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Technician whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Technician whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Technician whereIdNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Technician whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Technician whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Technician withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Technician withoutTrashed()
 * @mixin \Eloquent
 */
class Technician extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bank_acc_id',
        'id_number',
        'user_id',
    ];

}
