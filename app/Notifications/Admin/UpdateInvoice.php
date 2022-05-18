<?php

namespace App\Notifications\Admin;

use App\Enum\NotifyType;
use App\Notifications\FireBaseChannel;
use App\Traits\NotifyTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UpdateInvoice extends Notification
{
    use NotifyTrait;
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $data;
    public function __construct(protected $order,protected $orderBill)
    {
        $title_ar = 'تم تعديل فاتوره';
        $title_en = 'A bill has been updated';
        $message_ar = 'تم تعديل الفاتوره رقم '.$this->orderBill['id'];
        $message_en = 'A bill has been updated No. '.$this->orderBill['id'];
        $this->data = [
            'title' => [
                'ar' => $title_ar,
                'en' => $title_en,
            ],
            'body' => [
                'ar' => $message_ar,
                'en' => $message_en,
            ],
            'type'=> NotifyType::UPDATEINVOICE,
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
