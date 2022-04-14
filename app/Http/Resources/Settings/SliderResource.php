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
            'image' => $this->image,
            'category_id' => $this->category_id ?? 0,
            'sub_category_id' => $this->sub_category_id ?? 0,
            'sub_category_title' => $this->subcategory['title'] ?? '',
            'sub_category_image' => $this->subcategory['icon'] ?? '',
        ];
    }
}
