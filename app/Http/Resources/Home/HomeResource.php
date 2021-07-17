<?php

namespace App\Http\Resources\Home;

use App\Http\Resources\Items\ItemsResource;
use App\Http\Resources\Settings\BannerResource;
use Illuminate\Http\Resources\Json\JsonResource;
class HomeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this['id'],
            'title' => $this['title'],
            'icon' => $this['icon'],
        ];
    }
}
