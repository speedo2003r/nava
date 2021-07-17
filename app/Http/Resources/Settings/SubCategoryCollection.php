<?php

namespace App\Http\Resources\Settings;

use App\Http\Resources\Items\ItemsResource;
use App\Http\Resources\Notifications\NotificationResource;
use App\Http\Resources\services\ServiceResource;
use App\Http\Resources\Settings\SubCategoryResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SubCategoryCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => SubCategoryResource::collection($this->collection),
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
