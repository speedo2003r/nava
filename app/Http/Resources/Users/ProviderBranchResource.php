<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\Users\AddressResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderBranchResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'              => $this->user->id,
            'branch_id'              => $this->id,
            'branch_name'      => $this['title'] ?? '',
            'store_name'      => $this->user->provider['store_name'] ?? '',
            'logo'            => $this->user->provider->logo,
            'distance'          =>  (string) $this->distance(request()['lat'],request()['lng']),
            'banner'          =>  $this->user->provider['banner'] ?? '',
            'text_color'          =>  $this->user->provider['text_color'] ?? '',
            'button_color'          =>  $this->user->provider['button_color'] ?? '',
            'background_color'          =>  $this->user->provider['background_color'] ?? '',
            'lat'          =>  $this['lat'],
            'lng'          =>  $this['lng'],

        ];
    }
}
