<?php

namespace App\Notifications\Channels;

use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;

class FcmChannel
{
    public function send($notifiable, $notification)
    {
        if (! $notifiable->fcm_token) {
            return;
        }

        if (! method_exists($notification, 'toFcm')) {
            return;
        }

        $message = $notification->toFcm($notifiable);

        Firebase::messaging()->send($message);
    }
}
