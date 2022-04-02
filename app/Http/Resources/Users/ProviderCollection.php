<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\Users\ProviderResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProviderCollection extends ResourceCollection
{
    public $collects = User::class;
    public function toArray($request)
    {
        if($request->has('lat') && $request->has('lng')){
            $stores = $this->collection->map(function ($query) use ($request){
                $query->distance = [
                    'lat' => $request->lat,
                    'lng' => $request->lng,
                ];
                $query->distance = $query->distance;
                return $query;
            })->sortBy('users.distance');
        }else{
            $stores = $this->collection;
        }
        return [
            'data' => ProviderResource::collection($stores),
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
