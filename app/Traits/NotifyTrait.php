<?php
namespace App\Traits;

use App\Models\User;
use App\Entities\Notification;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

trait NotifyTrait
{

#send notify
    function send_notify($to_id, $message_ar, $message_en, $order_id = null, $order_status = null,$type = null)
    {
        $user = User::find($to_id);
        $notification = new Notification();
        $notification->to_id        = $to_id;
        $notification->from_id        = auth()->check() ? auth()->id() : $to_id;
        $notification->message_ar   = $message_ar;
        $notification->message_en   = $message_en;
        $notification->type         = is_null($order_id) ? 'notify' : ($type != null ? $type : 'order');
        $notification->order_id     = $order_id;
        $notification->order_status = $order_status;
        $notification->seen         = 0;
        $notification->save();
        if($user){
            $data['title'] = app()->getLocale() == 'ar' ? $message_ar: $message_en;
            $data['body'] = app()->getLocale() == 'ar' ? $message_ar: $message_en;
            if($user->Devices){
                foreach ($user->Devices as $device) {
                    if($device->device_id != null){
                        $this->send_fcm($device->device_id, $data, $device->device_type);
                    }
                }
            }

        }
    }
#send FCM
    function send_fcm($device_id, $data, $type, $setBadge = 0)
    {
        $priority = 'high'; // or 'normal'
        // $action = 'FLUTTER_NOTIFICATION_CLICK';
        // if ($device->device_type == 'web') $action = '/';
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 20);
        $optionBuilder->setPriority($priority);
        $notificationBuilder = new PayloadNotificationBuilder($data['title']);
        $notificationBuilder->setBody($data['body'])->setSound('default');
        //$notificationBuilder->setBody($data['message'])->setSound('default')->setBadge($setBadge)->setClickAction($action);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData($data);
        $data = $dataBuilder->build();
        if ($type == 'android') {
            $downstreamResponse = FCM::sendTo($device_id, $option, $notification, $data);
        } else {
            $downstreamResponse = FCM::sendTo($device_id, $option, $notification, $data);
        }
        $downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();
    }
}
