<?php

namespace App\Http\Resources\services;

use App\Http\Resources\Users\AddressResource;
use Illuminate\Http\Resources\Json\JsonResource;
class SingleAdResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'              => $this->id,
            'file'              => $this->file, //video or image
            'type_video'              => preg_match('/^.*\.(mp4|mov|mpg|mpeg|wmv|mkv)$/i', $this->file) ? true : false, //video or image
            'title'              => $this->title ?? '',
            'desc'              => $this->desc ?? '',
            'phone'              => $this->phone ?? '',
            'whatsapp'              => $this->whatsapp ?? '',
        ];
    }
}
