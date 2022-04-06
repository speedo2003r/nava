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
class Branch extends Model implements Transformable
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
        'assign_deadline',
        'city_id',
    ];
    public function city()
    {
        return $this->belongsTo(City::class,'city_id');
    }
    public function regions()
    {
        return $this->belongsToMany(Region::class,'branch_regions','branch_id','region_id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class,'users_branches','branch_id','user_id');
    }
}
