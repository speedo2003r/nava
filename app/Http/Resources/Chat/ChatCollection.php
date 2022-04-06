<?php

namespace App\Http\Resources\Chat;

use App\Http\Resources\Chat\ChatResource;
use App\Http\Resources\Notifications\NotificationResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ChatCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => ChatResource::collection($this->collection->sortBy('created_at')),
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
