<?php

namespace App\Http\Resources\Settings;

use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'image' => $this->image ?? '',
        ];
    }
}
