<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'last_name'      => $this->last_name ?? '',
            'phone'      => $this->phone ?? '',
            'lat'       => $this->lat,
            'lng'       => $this->lng,
            'map_desc'  => $this->map_desc,
            'address_details'  => $this->address_details ?? '',
            'type'      => $this->type ?? '',
            'is_main'   => (bool) $this->is_main,
        ];
    }
}
