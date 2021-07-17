<?php

namespace App\Http\Resources\Settings;

use Illuminate\Http\Resources\Json\JsonResource;

class IntroResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'image' => $this->image,
            //'title' => $this->title,
            'desc'  => $this->desc,
        ];
    }
}
