<?php

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => false,

    'http' => [
        'server_key' => env('FCM_SERVER_KEY', 'AAAAECMXUcI:APA91bFNQ89vOym4-zar9KGqtdCm_awoq1Uj9O3SlST0dpUs8n3p0ojkeZAmmri5ftKbAfWG7omkNt5bFu2fr40TeqYzRpHqOSPPfOAJooKV8MZwcCXdvPZJ50EtB8rMILy4sR30eo69'),
        'sender_id' => env('FCM_SENDER_ID', '69308207554'),
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'timeout' => 30.0, // in second
    ],
];
