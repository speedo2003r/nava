<?php

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => false,

    'http' => [
        'server_key' => env('FCM_SERVER_KEY', 'AAAAFvl2k9Y:APA91bHy7MS0pC8ccpPx6hycfpXAuPKynOWL0IXMcbUaUXjERC5WvNbIDbPBkZgEPZWRkDdUNeD6z7gU8ajyuxooV4155TExVM-JkDWeqU3rIjZHZgvsO2Sl5TgFxMdqQkgNtanwWspd'),
        'sender_id' => env('FCM_SENDER_ID', '98674578390'),
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'timeout' => 30.0, // in second
    ],
];
