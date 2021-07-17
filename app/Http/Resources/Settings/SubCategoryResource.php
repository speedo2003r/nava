<?php

namespace App\Http\Resources\Settings;

use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->icon ?? '',
        ];
    }
}
