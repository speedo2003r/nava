<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Image.
 *
 * @package namespace App\Entities;
 * @property int $id
 * @property string $image_type
 * @property int $image_id
 * @property string $media_type
 * @property string|null $image
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Model|\Eloquent $imageable
 * @method static \Illuminate\Database\Eloquent\Builder|Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image newQuery()
 * @method static \Illuminate\Database\Query\Builder|Image onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Image query()
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereImageType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereMediaType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Image withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Image withoutTrashed()
 * @mixin \Eloquent
 */
class Image extends Model implements Transformable
{
    use TransformableTrait;

    use SoftDeletes;
    public $fillable = [
        'image_id',
        'image_type',
        'media_type',
        'image'
    ];
    public function imageable()
    {
        return $this->morphTo();
    }

}
