<?php

namespace App\Http\Resources\Chat;

use App\Http\Resources\Users\AddressResource;
use Illuminate\Http\Resources\Json\JsonResource;
class ChatResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'              => $this->id ?? '',
            'is_sender' => $this->is_sender,
            'user_id' => $this->user_id,
            'message' => $this->id ? [
                'id'=>$this->message['id'],
                'body'=>$this->message['body'],
                'room_id'=>$this->message['room_id'],
                'user_id'=>$this->message['user_id'],
                'type'=>$this->message['type'],
                'created_at' => date('Y-m-d H:i:s',strtotime($this->message['created_at'])),
            ] : '',
            'type' => $this->id ? $this->message['type'] : '',
            'is_seen' => $this->is_seen,
            'order_finish' => $this->room->order['status'] == 'done' ? true : false,

        ];
    }
}
