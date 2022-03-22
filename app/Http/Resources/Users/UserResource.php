<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\Users\AddressResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'                        => $this->id,
            'name'                      => $this->name,
            'avatar'                      => $this->avatar ?? '',
            'email'                      => $this->email && $this->email != 'user'.$this['id'].'@nava.com' ? $this->email : '',
            'phone'                     => $this->phone,
            'lang'                      => $this->lang,
            'online'                    => $this->online ?? 0,
            'active'                    => $this->active,
            'user_type'                    => $this->user_type ?? '',
        ];
    }
}
