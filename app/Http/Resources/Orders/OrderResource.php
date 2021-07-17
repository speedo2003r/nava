<?php

namespace App\Http\Resources\Orders;

use App\Entities\Order;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order_num' => $this->order_num,
            'address'   => $this['map_desc'] ?? '',
            'lat'   => $this['lat'] ?? '',
            'lng'   => $this['lng'] ?? '',
            'date' => Carbon::parse($this->date)->format('Y/m/d'),
            'time' => Carbon::parse($this->time)->locale(app()->getLocale())->format('h:i a'),
        ];
    }

}
