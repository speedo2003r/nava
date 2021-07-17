<?php

namespace App\Http\Resources\Chat;

use App\Http\Resources\Users\AddressResource;
use Illuminate\Http\Resources\Json\JsonResource;
class RoomResource extends JsonResource
{
    public function toArray($request)
    {
        $msg = app()->getLocale() == 'ar' ? $this->order['order_num'].'مرحبا أنا مندوب طلبك رقم ' : 'hello i am delegate for your order num '.$this->order['order_num'];
        return [
            'id'              => $this->id ?? '',
            'name' => $this->Owner['name'],
            'avatar' => $this->Owner['avatar'],
            'last_message_id' => $this->last_message_id,
            'last_message' => $this->LastMessage ?? [
                'id'=>0,
                'body'=>$msg,
                'room_id'=>$this->order->room['id'],
                'user_id'=>$this->order['user_id'],
                'type'=>'text',
                'created_at' => date('Y-m-d H:i:s',strtotime($this->order['created_at'])),
            ] ,
            'seen_count' => $this->Messages()->where('is_seen',0)->count(),
            'time' => $this->LastMessage ? date('H:i a',strtotime($this->LastMessage['created_at'])) : date('H:i a',strtotime($this['created_at'])),
            'status' => $this->order['status'],

        ];
    }
}
