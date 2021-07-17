<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\Users\AddressResource;
use Illuminate\Http\Resources\Json\JsonResource;
class ProviderItemsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'              => $this->id,
            'seller_id'       => $this->user['id'],
            'title'           => $this->title,
            'price'           => $this->main_price(),
            'image'           => $this->main_image,
        ];
    }
}
