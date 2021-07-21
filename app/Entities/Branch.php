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
        'user_id',
        'assign_deadline',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function regions()
    {
        return $this->belongsToMany(Region::class,'branch_regions','branch_id','region_id');
    }
    public function services()
    {
        return $this->belongsToMany(Service::class,'branch_services','branch_id','service_id');
    }
}
