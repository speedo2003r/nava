<?php

namespace App\Http\Resources\Orders;

use App\Entities\Order;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TechnicalOrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'avatar' => $this->user['avatar'],
            'name' => $this->user['name'],
            'address' => ($this->city ? $this->city['title'].' - ' : '').($this->region ? $this->region['title'].' - ' : '').$this->street,
            'order_num' => $this->order_num,
            'created_date' => \Carbon\Carbon::parse($this->created_date)->diffForHumans(),
            'date' => $this->date ?? '',
            'time' => $this->time ?? '',
            'status'   => (!in_array($this['status'],['finished','canceled','created']) && $this['technician_id'] != null)  ? trans($this['status']) : ($this['status'] == 'finished' ? trans('api.finished')  :trans('api.new')),
            'order_status'   => $this['status'],
        ];
    }

}
