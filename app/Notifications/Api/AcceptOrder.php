<?php

namespace App\Notifications\Api;

use App\Enum\NotifyType;
use App\Notifications\FireBaseChannel;
use App\Traits\NotifyTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AcceptOrder extends Notification
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
        $title_ar = 'تم الموافقه علي طلبك';
        $title_en = 'Your request has been approved';
        $message_ar = 'تم الموافقه علي طلبك وجاري تنفيذه الأن التقني في الطريق اليك';
        $message_en = 'Your request has been approved and is being implemented. The technician is on the way to you';
        $this->data = [
            'title' => [
                'ar' => $title_ar,
                'en' => $title_en,
            ],
            'body' => [
                'ar' => $message_ar,
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
