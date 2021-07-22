<?php

namespace App\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Spatie\Translatable\HasTranslations;

/**
 * Class Bank.
 *
 * @package namespace App\Entities;
 */
class Credit extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'holder_name',
        'card_number',
        'pass',
        'expire_card',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
