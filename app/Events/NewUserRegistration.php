<?php

namespace App\Events;

class NewUserRegistration extends Event
{
    public $Model;

    public function __construct($request)
    {
        $Model = $request->Payload->all()['Model'];
        $this->Model = $Model;
    }
}
