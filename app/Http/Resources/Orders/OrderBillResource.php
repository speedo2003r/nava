<?php

namespace App\Http\Resources\Orders;

use App\Entities\Category;
use App\Http\Resources\Users\AddressResource;
use App\Models\Order;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderBillResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'notes'                => $this->text,
            'tax'                => $this->vat_amount,
            'price'                => $this->price,
        ];
    }
}
