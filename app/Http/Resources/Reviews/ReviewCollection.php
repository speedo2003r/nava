<?php

namespace App\Http\Resources\Reviews;

use App\Http\Resources\Items\ItemsResource;
use App\Http\Resources\Notifications\NotificationResource;
use App\Http\Resources\services\ServiceResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ReviewCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => ReviewResource::collection($this->collection),
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
