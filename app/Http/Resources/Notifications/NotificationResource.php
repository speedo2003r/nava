<?php

namespace App\Http\Resources\Notifications;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'to_id'      => $this->to_id,
            'message'    => $this->message,
            'seen'       => $this->seen == 1 ? true : false,
            'type'       => $this->type??'',
            'order_id'    => $this->order_id??0,
            'created_at' => $this->created_at->diffForHumans(),
        ];

    }
}
