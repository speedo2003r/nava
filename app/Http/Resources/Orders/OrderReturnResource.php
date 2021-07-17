<?php

namespace App\Http\Resources\Orders;

use App\Entities\Order;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderReturnResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order_num' => $this->order_num,
            'store_name'   => $this->provider ? $this->provider->provider['store_name'] : '',
            'date' => Carbon::parse($this->date)->locale(app()->getLocale())->format('Y M d'),
            'status' => $this->status,
            'statusName' => Order::userStatus($this->status),
            'items' => $this->itemDetails($this),
            'notes' => $this->reclaims()->first()['notes'],
            'created_at' => date('Y-m-d',strtotime($this->reclaims()->first()['created_at'])),
        ];
    }

    public function itemDetails($order)
    {
        $orderProducts = $order->orderProducts()->whereHas('item',function ($query){
            $query->where('reclaim',1);
        })->get();
        $orderProducts = $orderProducts->map(function ($query){
            return [
                'id' => $query['id'],
                'title'             => $query->item->type == 'single' ? $query->item['title'] : $query->group['title'],
                'image'             => $query->item->type == 'single' ? $query->item->main_image : $query->group->group_image(),
            ];
        });
        return $orderProducts;
    }
}
