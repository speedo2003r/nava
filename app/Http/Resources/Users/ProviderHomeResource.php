<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class ProviderHomeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'order_num'   => $this->order_num,
            'map_desc'    => $this->Address->map_desc??'',
            'user_name'   => $this->User->name,
            'user_avatar' => $this->User->avatar,
        ];
    }
}
