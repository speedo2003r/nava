<?php

namespace App\Http\Resources\Orders;

use App\Entities\Order;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TechnicalGuaranteeOrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->order->id,
            'name' => $this->order->user['name'],
            'address' => $this->order->city['title'].' - '.$this->order->region['title'].' - '.$this->order->street,
            'order_num' => $this->order->order_num,
            'created_date' => \Carbon\Carbon::parse($this->order->created_date)->diffForHumans(),
            'date' => $this->order->date ?? '',
            'time' => $this->order->time ?? '',
            'status'   => ($this->order['status'] != 'finished' && $this->order['status'] != 'canceled' && $this->order['status'] != 'created' && $this->order['technician_id'] != null)  ? trans('api.notdoneyet') : trans('api.new'),
        ];
    }

}
