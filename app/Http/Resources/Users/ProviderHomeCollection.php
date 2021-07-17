<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\Users\ProviderHomeResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProviderHomeCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => ProviderHomeResource::collection($this->collection),
            'pagination' => [
                'total'         => $this->total(),
                'count'         => $this->count(),
                'per_page'      => $this->perPage(),
                'current_page'  => $this->currentPage(),
                'total_pages'   => $this->lastPage(),
                //'next_page_url' => $this->nextPageUrl(),
            ],
        ];
    }
}
