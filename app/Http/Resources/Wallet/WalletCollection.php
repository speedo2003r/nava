<?php

namespace App\Http\Resources\Wallet;

use App\Http\Resources\Wallet\WalletResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class WalletCollection extends ResourceCollection
{
    public function toArray($request)
    {
      return [
        'data' => WalletResource::collection($this->collection),
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
