<?php

namespace App\Http\Resources\Orders;

use App\Entities\Order;
use App\Http\Resources\Users\AddressResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DelegateOrderDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'   => $this->id,
            'order_num'   => $this->order_num,
            'shipping_price' => (string) $this->shipping_price,
            'room_id'=>$this->room['id'] ?? 0,
            'user' => [
                'id' => $this->user['id'],
                'phone' =>  $this->address['phone'],
                'price' => (string) $this->_price(),
                'currency' => app()->getLocale() == 'ar' ? 'ر.س' :'SAR',
                'date' => $this->date ? date('Y-m-d',strtotime($this->date)) : $this->created_at->format('Y-m-d'),
                'time' => $this->time ? date('h:i a',strtotime($this->time)) : $this->created_at->format('h:i a'),
                'user_address' => new AddressResource($this->address) ,
                'lat' => $this->address['lat'],
                'lng' => $this->address['lng'],
                'pay_type' => $this->pay_type == 'cash' ? trans('api.cod') : trans('api.online'),
            ],
            'seller' => [
                'id' => $this->provider['id'],
                'logo' => $this->provider->avatar,
                'store_name' => $this->provider->provider['store_name'],
                'phone' => $this->provider['phone'],
                'address' => $this->provider['address'] ?? '',
                'lat' => $this->provider['lat'] ?? '',
                'lng' => $this->provider['lng'] ?? '',
            ],
            'items' => OrderProductResource::collection($this->orderProducts),
            'status' => $this->delegateStatus(),
            'status_name' => $this->delegate_status ? $this->delegate_status : '',
        ];
    }
}
