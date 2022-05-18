<?php

namespace App\Notifications\Api;

use App\Enum\NotifyType;
use App\Events\UpdateNotification;
use App\Notifications\BroadcastChannel;
use App\Notifications\FireBaseChannel;
use App\Traits\NotifyTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactNotify extends Notification
{
    use NotifyTrait;
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $data;
    public function __construct(protected $message_ar,protected $message_en)
    {
        $title_ar = 'رساله جديده';
        $title_en = 'new message';
        $this->data = [
            'title' => [
                'ar' => $title_ar,
                'en' => $title_en,
                'ur' => $title_ar,
            ],
            'body' => [
                'ar' => $this->message_ar,
                'ur' => $this->message_ar,
                'en' => $this->message_en,
            ],
            'type'=> NotifyType::NEWMESSAGECONTACT,
        ];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [BroadcastChannel::class,'database',FireBaseChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toDatabase($notifiable)
    {
        return $this->data;
    }
    public function toBroadcast($notifiable)
    {
        return broadcast(new UpdateNotification($notifiable));
    }
    public function toFireBase($notifiable)
    {
        $this->data['title'] = $this->data['title'][$notifiable['lang']];
        $this->data['body'] = $this->data['body'][$notifiable['lang']];
        if($notifiable->Devices) {
            foreach ($notifiable->Devices as $device) {
                if ($device->device_id != null) {
                    return $this->send_fcm($device['device_id'], $this->data, $this->data['type']);
                }
            }
        }
    }
}
