<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class BroadcastChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toBroadcast($notifiable);
    }
}
