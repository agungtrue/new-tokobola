<?php

namespace App\Events\Loan;

use App\Events\Event;

class Approval extends Event
{
    public $Model;

    public function __construct($request)
    {
        $Model = $request->Payload->all()['Model'];
        $this->Model = $Model;
    }
}
