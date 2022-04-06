<?php

namespace App\Http\Resources\Reviews;

use App\Http\Resources\Users\AddressResource;
use Illuminate\Http\Resources\Json\JsonResource;
class ReviewResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'              => $this->id,
            'avatar'              => $this->user['avatar'],
            'name'              => $this->user['name'],
            'rate'              => $this->rate,
            'comment'              => $this->comment,
        ];
    }
}
