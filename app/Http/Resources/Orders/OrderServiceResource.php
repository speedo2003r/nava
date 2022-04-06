<?php

namespace App\Http\Resources\Orders;

use App\Entities\ReviewRate;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderServiceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'provider_name'     => $this->order->provider['name'] ?? '',
            'image'             => $this->service['image'],
            'title'                => $this->service['title'],
            'price'                => $this->price,
        ];
    }
}
