<?php

namespace App\Http\Resources\Orders;

use App\Entities\Order;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class DelegateOrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'   => $this->id,
            'order_num'   => $this->order_num,
            'store_name'   => $this->provider ? $this->provider->provider['store_name'] : '',
            'logo'   => $this->provider ? $this->provider['avatar'] : '',
            'created_at'   => $this->created_at->format('d-m-Y h:i a'),
            'price'   => $this->_price(),
            'status'   => $this->delegate_status,
            'status_name' => Order::delegateStatus($this->delegate_status),
        ];
    }
}
