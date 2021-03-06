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
            'address' => ($this->city ? $this->city['title'].' - ' : '').$this->map_desc,
            'order_num' => $this->order_num,
            'category_icon' => $this->category ? $this->category['icon'] : '',
            'category_title' => $this->category ? $this->category['title'] : '',
            'room_id' => $this->room ? $this->room['id'] : 0,
            'created_date' => \Carbon\Carbon::parse($this->created_date)->diffForHumans(),
            'date' => $this->date ?? '',
            'time' => $this->time ?? '',
            'distance' => (request('lat') && request('lng')) ? (string) round(distance(request('lat'),request('lng'),$this['lat'],$this['lng']),2) ? '0',
            'status'   => (!in_array($this['status'],['finished','canceled','created']) && $this['technician_id'] != null)  ? trans($this['status']) : ($this['status'] == 'finished' ? trans('finished')  :trans('new')),
            'order_status'   => $this['status'],
        ];
    }

}
