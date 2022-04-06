<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class LatLngResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'                        => $this->id,
            'lat'                      => $this->lat ? (string) $this->lat : (string) $this->addresses['lat'],
            'lng'                     => $this->lng ? (string) $this->lng : (string) $this->addresses['lng'],
        ];
    }
}
