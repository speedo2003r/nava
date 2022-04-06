<?php

namespace App\Http\Resources\services;

use App\Http\Resources\Users\AddressResource;
use Illuminate\Http\Resources\Json\JsonResource;
class ServiceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'              => $this->id,
            'image'              => $this->image,
            'title'              => $this->title ?? '',
            'price'              => $this->price ?? 0,
            'rate'      => $this->ratingService ? $this->ratingService['rate'] : 0,
        ];
    }
}
