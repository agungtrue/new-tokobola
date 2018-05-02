<?php

namespace App\Support\Realtime;

use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;
use Milkyway\Equinox\Support\Realtime\Realtime;

class Courier
{

    public static function Send($Payload)
    {
        Redis::connection('redis_system')
            ->publish('email-notification', json_encode($Payload));
    }
}
