<?php

namespace App\Http\Resources\Orders;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order_num' => $this->order_num ?? '',
            'banner' => $this->provider['banner'] ?? '',
            'service_name' => $this->provider->category['title'] ?? '',
            'provider_name' => $this->provider['name'] ?? '',
            'services' => OrderServiceResource::collection($this->orderServices),
        ];
    }
}
