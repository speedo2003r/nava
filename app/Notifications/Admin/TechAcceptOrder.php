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

class TechAcceptOrder extends Notification
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
        $title_ar = 'تم الموافقه علي طلب من قبل تقني';
        $title_ur = 'تم الموافقه علي طلب من قبل تقني';
        $title_en = 'there is order has been approved from technical';
        $message_ar = 'تم الموافقه علي طلب رقم '.$this->order['order_num'].' وجاري تنفيذه الأن التقني في الطريق الي العميل';
        $message_ur = 'تم الموافقه علي طلب رقم '.$this->order['order_num'].' وجاري تنفيذه الأن التقني في الطريق الي العميل';
        $message_en = 'order number '.$this->order['order_num'].' has been approved and is being implemented. The technician is on the way to client';
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
            'type'=> NotifyType::ACCEPTORDER,
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
