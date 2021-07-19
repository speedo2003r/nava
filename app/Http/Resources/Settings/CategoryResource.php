<?php

namespace App\Http\Resources\Settings;

use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->icon ?? '',
            'childExist' => count($this->children) > 0 ? true : false,
            'hasPledge' => $this->pledge == 1 ? true : false,
        ];
    }
}