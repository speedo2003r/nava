<?php

namespace App\Http\Resources\services;

use App\Http\Resources\Users\AddressResource;
use Illuminate\Http\Resources\Json\JsonResource;
class AdResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'              => $this->id,
            'image'              => $this->image,
            'title'              => $this->title ?? '',
            'desc'              => $this->desc ?? '',
        ];
    }
}
