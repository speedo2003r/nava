<?php

namespace App\Notifications\Api;

use App\Enum\NotifyType;
use App\Notifications\FireBaseChannel;
use App\Traits\NotifyTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AssignDelegate extends Notification
{
    use NotifyTrait;
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(protected $order)
    {
        $title_ar = 'تم تعيينك لطلب جديد';
        $title_ur = 'تم تعيينك لطلب جديد';
        $title_en = 'You have been assigned a new request';
        $message_ar = 'تم تعيينك للطلب رقم '.$this->order['order_num'];
        $message_ur = 'تم تعيينك للطلب رقم '.$this->order['order_num'];
        $message_en = 'You have been assigned to a new order No.'.$this->order['order_num'];
        $this->data = [
            'title' => [
                'ar' => $title_ar,
                'en' => $title_en,
                'ur' => $title_ur,
            ],
            'body' => [
                'ar' => $message_ar,
                'en' => $message_en,
                'ur' => $message_ur,
            ],
            'type'=> NotifyType::ASSIGNORDER,
            'order_id'=> $this->order['id'],
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
    public function toDatabase($notifiable)
    {
        return $this->data;
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
