<?php

namespace App\Notifications\Admin;

use App\Enum\NotifyType;
use App\Events\UpdateNotification;
use App\Notifications\BroadcastChannel;
use App\Notifications\FireBaseChannel;
use App\Traits\NotifyTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TechFinishOrder extends Notification
{
    use NotifyTrait;
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $data;
    public function __construct(protected $order)
    {
        $title_ar = 'تم انهاء الطلب';
        $title_ur = 'تم انهاء الطلب';
        $title_en = 'there is order has been completed';
        $message_ar = 'تم انهاء الطلب رقم '.$this->order['order_num'];
        $message_ur = 'تم انهاء الطلب رقم '.$this->order['order_num'];
        $message_en = 'Order No. has been completed'.$this->order['order_num'];
        $this->data = [
            'title' => [
                'ar' => $title_ar,
                'ur' => $title_ur,
                'en' => $title_en,
            ],
            'body' => [
                'ar' => $message_ar,
                'ur' => $message_ur,
                'en' => $message_en,
            ],
            'type'=> NotifyType::FINISHORDER,
            'order_id'=> $this->order['id'],
            'status'=> $this->order['status'],
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
