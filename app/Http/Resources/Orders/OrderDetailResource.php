<?php

namespace App\Http\Resources\Orders;

use App\Http\Resources\Users\AddressResource;
use App\Models\Order;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'banner' => $this->provider['banner'] ?? '',
            'service_name' => $this->provider->category['title'] ?? '',
            'provider_name' => $this->provider['name'] ?? '',
            'address' => $this['map_desc'] ?? '',
            'lat' => $this['lat'] ?? '',
            'lng' => $this['lng'] ?? '',
            'order_num' => $this->order_num,
            'date' => Carbon::parse($this->date)->format('Y/m/d'),
            'time' => Carbon::parse($this->time)->locale(app()->getLocale())->format('h:i a'),
            'totalPrice' => $this->_price(),
            'currency' => trans('api.SAR'),
            'services' => OrderServiceResource::collection($this->orderServices),
        ];
    }
}
