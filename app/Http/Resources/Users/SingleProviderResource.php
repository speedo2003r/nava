<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\Users\AddressResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SingleProviderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'              => $this->id,
            'name'      => $this['name'] ?? '',
            'banner'      => $this['banner'] ?? '',
            'rate'      => $this->ratingUser ? $this->ratingUser['rate'] : 0,
            'service_desc'      => $this['service_desc'],
        ];
    }
}
