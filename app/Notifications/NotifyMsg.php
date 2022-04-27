<?php

namespace App\Notifications;

use App\Enum\NotifyType;
use App\Enum\UserType;
use App\Events\UpdateNotificationsMessages;
use App\Traits\NotifyTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyMsg extends Notification
{
    use NotifyTrait;
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $data;
    public function __construct(protected $message)
    {
        $title_ar = 'لديك رساله جديده';
        $title_ur = 'لديك رساله جديده';
        $title_en = 'You have a new message';
        $this->data = [
            'title' => [
                'ar' => $title_ar,
                'ur' => $title_ur,
                'en' => $title_en,
            ],
            'body' => [
                'ar' => $this->message,
                'ur' => $this->message,
                'en' => $this->message,
            ],
            'type'=>NotifyType::CHAT
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
        return [BroadcastChannel::class,FireBaseChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */

    public function toBroadcast($notifiable)
    {
        if($notifiable['user_type'] == UserType::ADMIN){
            return broadcast(new UpdateNotificationsMessages($notifiable));
        }
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
