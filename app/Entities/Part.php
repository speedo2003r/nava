<?php

namespace App\Entities;

use App\Models\User;
use App\Entities\RatingService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Spatie\Translatable\HasTranslations;

/**
 * Class Slider.
 *
 * @package namespace App\Entities;
 * @property int $id
 * @property array|null $title
 * @property array|null $description
 * @property int $service_id
 * @property float $price
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read array $translations
 * @property-read \App\Entities\Service $service
 * @method static \Illuminate\Database\Eloquent\Builder|Part newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Part newQuery()
 * @method static \Illuminate\Database\Query\Builder|Part onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Part query()
 * @method static \Illuminate\Database\Eloquent\Builder|Part whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Part whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Part whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Part whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Part wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Part whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Part whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Part whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Part withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Part withoutTrashed()
 * @mixin \Eloquent
 */
class Part extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;
    use HasTranslations;

    public $translatable = ['title','description'];
    protected $fillable = [
        'title',
        'description',
        'service_id',
        'price',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
