<?php

namespace App\Http\Resources\Settings;

use App\Http\Resources\Users\ProviderResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id ?? '',
            'title' => (string) $this->title ?? '',
            'provider_id' => (string) $this->user_id ?? '',
            'itemable_id' => $this->itemable_id ?? '',
            'image' => $this->image,
        ];
    }
}