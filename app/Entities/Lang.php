<?php

namespace App\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Banner.
 *
 * @package namespace App\Entities;
 * @property int $id
 * @property string $name
 * @property string $lang
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Lang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lang query()
 * @method static \Illuminate\Database\Eloquent\Builder|Lang whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lang whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lang whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lang whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lang whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Lang extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'lang',
    ];

}
