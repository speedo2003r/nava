<?php

namespace App\Http\Resources\Orders;

use App\Entities\Favourite;
use App\Entities\Group;
use App\Entities\ReviewRate;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
{
    public function toArray($request)
    {

        if(auth()->check()){
            $fav = Favourite::where('user_id',auth()->id())->where('favoritable_id',$this->group['id'])->where('favoritable_type',Group::class)->first();
            $checkfav = $fav != null ? true : false;
        }else{
            $fav = Favourite::where('uuid',$request['uuid'])->where('user_id',null)->where('favoritable_id',$this->group['id'])->where('favoritable_type',Group::class)->first();
            $checkfav = $fav != null ? true : false;
        }
        $exists = ReviewRate::where('user_id',auth()->id())->where('order_id',$this->order['id'])->where('rateable_id',$this->group['id'])->where('rateable_type',Group::class)->exists();
        return [
            'id'                => $this->id,
            'group_id'          => $this->group['id'],
            'title'             => $this->item->type == 'single' ? $this->item['title'] : $this->group['title'],
            'image'             => $this->item->type == 'single' ? $this->item->main_image : $this->group->group_image(),
            'category_title'    => $this->item->subcategory['title'],
            'main_price'             => $this->price,
            'provider'        => $this->item->user ? $this->item->user->provider['store_name'] : '',
            'currency'          => trans('api.SAR'),
            'count'             => $this->qty,
            'availableCount'    => $this->group['count'],
            'favorite'          => $checkfav,
            'rateExist'          => $exists,
        ];
    }
}
