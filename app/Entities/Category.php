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
    public function providers()
    {
        return $this->hasMany(User::class,'category_id','id');
    }
    public function children()
    {
        return $this->hasMany(Category::class,'parent_id','id');
    }
    public function parent()
    {
        return $this->belongsTo(Category::class,'parent_id');
    }
}
