<?php

namespace App\Http\Resources\Orders;

use App\Entities\Order;
use App\Enum\OrderStatus;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order_num' => $this->order_num,
            'category_title'   => $this->category ? $this->category['title'] : '',
            'price'   => $this->status == OrderStatus::FINISHED ? (string) round($this->final_total,2) : $this->price(),
            'status'   => ($this['status'] != 'finished' && $this['status'] != 'canceled') ? ($this->bills()->where('order_bills.status',0)->exists() ? trans('api.youhavefactora') : '') : trans('api.rate'),
        ];
    }

}
