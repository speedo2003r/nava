<?php

namespace App\Events;

use App\Models\Message_notification;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $user_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Message_notification $message,$user_id)
    {
        $this->message = $message;
        $this->user_id = $user_id;
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('rooms.' . $this->message->room_id);
    }
    public function broadcastWith()
    {
        $message = $this->message->with('Message')->where('user_id',$this->user_id)->where('is_delete',0)->get()->last();
        if($message){
            return [
                'created_at'=> $message['created_at'],
                'id'=> $message['id'],
                'is_delete'=> $message['is_delete'],
                'is_sender'=> 0,
                'message'=> $message->Message,
                'message_id'=> $message['message_id'],
                'room_id'=> $message['room_id'],
                'updated_at'=> $message['updated_at'],
                'user_id'=> $message['user_id'],
            ];
        }

    }
}
