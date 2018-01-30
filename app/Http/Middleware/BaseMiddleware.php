<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use App\Support\Response\Json;
use App\Support\Validation\InputValidation;

abstract class BaseMiddleware
{
    protected $_Request;
    protected $Model;
    protected $Payload;

    public function __construct(Request $request)
    {
        $this->Json = Json::class;
        $this->Validator = InputValidation::class;
        $this->Model = (object)[];
        $this->Payload = collect([]);
        $this->_Request = $request;
    }

    public function setRequest($request)
    {
        $this->_Request = $request;
    }

    public function mergeRequest($key, $data = [])
    {
        return $this->_Request;
    }
}
