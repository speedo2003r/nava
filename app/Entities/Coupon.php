<?php

namespace App\Entities;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Coupon.
 *
 * @package namespace App\Entities;
 */
class Coupon extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
        'kind',
        'code',
        'value',
        'max_use',
        'count',
        'start_date',
        'end_date',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class);
    }

    public function couponValue($value,$seller_id = null,$orderProducts = [])
    {
        $price = 0;
        if($this->type === 'public' && $this->start_date <= Carbon::now()->format('Y-m-d') && $this->end_date >= Carbon::now()->format('Y-m-d')){
            if($this->kind == 'percent'){
                $price = ($value * $this->value) / 100;
            }elseif ($this->kind == 'fixed'){
                $price = $this->value;
            }
        }elseif ($this->type == 'private'){
            if (count($orderProducts) > 0){
                if(in_array($this->item_id,$orderProducts)){
                    $item = Item::whereIn('id',$orderProducts)->first();
                    $price = ($item->groups()->first()->price() * $this->value) / 100;
                }
            }
        }
        return (string) round($price,2);
    }
}
