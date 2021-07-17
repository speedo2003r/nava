<?php

namespace App\Http\Resources\Orders;

use App\Entities\OrderProduct;
use App\Entities\UserAddress;
use App\Http\Resources\Users\AddressResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CartDetailResource extends JsonResource
{
    public function toArray($request)
    {
        $count = OrderProduct::where('order_id',$this->id)->sum('qty');
        $price = 0;
        $orderProducts = OrderProduct::where('order_id',$this->id)->get();
        foreach ($orderProducts as $orderProduct){
            $price += $orderProduct['price'] * $orderProduct['qty'];
        }
        return [
            'id'                => $this->id,
            'order_num'                => $this->order_num,
            'count'                => $count ?? 0,
            'user_address'                =>  new AddressResource($this->address),
            'store_name'        => $this->provider ? $this->provider->provider['store_name'] : '',
            'branch_name'        => $this->branch ? $this->branch['title'] : '',
            'distance'        => $this->branch->distance($this->address['lat'],$this->address['lng']),
            'items'             => OrderProductResource::collection($this->orderProducts),
        ];
    }
}
