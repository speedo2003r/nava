<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\Users\AddressResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'              => $this->id,
            'name'      => $this['store_name'] ?? '',
            'avatar'      => $this['avatar'] ?? '',
            'rate'      => $this->ratingUser ? $this->ratingUser['rate'] : 0
        ];
    }
}
