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
 * @property array $title
 * @property string|null $icon
 * @property int $guarantee_days عدد أيام الضمان
 * @property int|null $parent_id
 * @property int $status
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Service[] $childServices
 * @property-read int|null $child_services_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Category[] $children
 * @property-read int|null $children_count
 * @property-read array $translations
 * @property-read Category|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $providers
 * @property-read int|null $providers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\Service[] $services
 * @property-read int|null $services_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Query\Builder|Category onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereGuaranteeDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Category withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Category withoutTrashed()
 * @mixin \Eloquent
 */
class Category extends Model implements Transformable
{
    use TransformableTrait;
    use HasTranslations;
    use SoftDeletes;

    public $translatable = ['title'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'icon',
        'guarantee_days',
        'parent_id',
        'status',
    ];

    public function getIconAttribute($value)
    {
        if($value == null){
            return  dashboard_url('images/placeholder.png');
        }
        return  dashboard_url('storage/images/categories/'. $value);
    }
    public function services()
    {
        return $this->hasMany(Service::class,'category_id','id');
    }

    public function ScopeExist($query)
    {
        return $query->whereHas('children',function($query){
            $query->whereHas('services',function ($query){
                $query->where('status',1);
            });
        });
    }
    public function providers()
    {
        return $this->hasMany(User::class,'category_id','id');
    }
    public function children()
    {
        return $this->hasMany(Category::class,'parent_id','id');
    }

    public function childServices()
    {
        return $this->hasManyThrough(Service::class,Category::class,'parent_id','category_id');
    }
    public function parent()
    {
        return $this->belongsTo(Category::class,'parent_id');
    }
}
