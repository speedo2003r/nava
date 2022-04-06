<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\Users\AddressResource;
use Illuminate\Http\Resources\Json\JsonResource;
class ProviderCategoriesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'              => $this->id,
            'title'           => $this->title,
        ];
    }
}