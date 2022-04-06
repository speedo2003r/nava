<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class FireBaseChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toFireBase($notifiable);
    }
}