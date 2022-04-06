<?php

namespace App\Http\Resources\Notifications;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'to_id'      => $this->notifiable_id,
            'message'    => $this->data['body'][app()->getLocale()],
            'seen'       => $this->read_at != null ? true : false,
            'type'       => $this->data['type']??'',
            'order_id'    => $this->data['order_id']??0,
            'created_at' => $this->created_at->diffForHumans(),
        ];

    }
}
