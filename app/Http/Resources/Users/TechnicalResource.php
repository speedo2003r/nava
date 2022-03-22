<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class TechnicalResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'avatar'        => $this->avatar,
            'name'      => $this->name,
            'phone'      => $this->phone ?? '',
            'categories'      => count($this->categories) > 0 ? $this->categories->map(function ($query){
                return [
                    'id' => $query['id'],
                    'title' => $query['title'],
                ];
            }) : [],
        ];
    }
}
