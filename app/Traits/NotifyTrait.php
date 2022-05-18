<?php
namespace App\Traits;

use App\Models\User;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

trait NotifyTrait
{

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
