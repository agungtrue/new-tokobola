<?php

namespace App\Listeners\NewUserRegistration;

use App\Events\NewUserRegistration;
use App\Support\Realtime\Courier;

class SendNotification
{
    public function handle(NewUserRegistration $event)
    {
        $mail = [
            'NotificationType' => 'NewUserRegistration',
            'payload' => [
                'to' => [
                    'address' => $event->Model->User->email,
                    'name' => $event->Model->User->name,
                ],
                'data' => []
            ]
        ];
        Courier::send($mail);
    }
}
