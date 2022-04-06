<?php

namespace App\Notifications\Api;

use App\Enum\NotifyType;
use App\Notifications\FireBaseChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DelegateRate extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $data;
    public function __construct(protected $title_ar,protected $title_en,protected $message_ar,protected $message_en,protected $order)
    {
        $this->data = [
            'title' => [
                'ar' => $this->title_ar,
                'en' => $this->title_en,
            ],
            'body' => [
                'ar' => $this->message_ar,
                'en' => $this->message_en,
            ],
            'type'=> NotifyType::DELEGATERATE,
            'order_id'=> $order['id'],
            'status'=> $order['status'],
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
        return ['database',FireBaseChannel::class];
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
    public function toDatabase($notifiable)
    {
        return $this->data;
    }

    public function toFireBase($notifiable)
    {
        if($notifiable->Devices) {
            foreach ($notifiable->Devices as $device) {
                if ($device->device_id != null) {
                    return $this->send_fcm($device['device_id'], $this->data, $this->data['type']);
                }
            }
        }
    }
}