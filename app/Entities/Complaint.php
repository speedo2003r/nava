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
