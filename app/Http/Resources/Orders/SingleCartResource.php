<?php

namespace App\Http\Resources\Orders;

use App\Entities\OrderProduct;
use Illuminate\Http\Resources\Json\JsonResource;

class SingleCartResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'provider_avatar'                => $this->provider['avatar'] ?? '',
            'order_num'                => $this->order_num ?? '',
            'service_name'                => $this->provider->category['title'] ?? '',
            'provider_name'                => $this->provider['name'] ?? '',
        ];
    }
}
