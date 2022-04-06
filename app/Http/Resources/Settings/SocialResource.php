<?php

namespace App\Http\Resources\Settings;

use Illuminate\Http\Resources\Json\JsonResource;

class SocialResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'key'   => $this->key ?? '',
            'value' => $this->value ?? '',
        ];
    }
}
