<?php

namespace App\Http\Middleware\User;

use App\Models\User;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Insert extends BaseMiddleware
{
    private function Instantiate()
    {
        $this->Model->User = new User();

        $this->Model->User->name = $this->_Request->input('name');
        $this->Model->User->username = $this->_Request->input('username');
        $this->Model->User->email = $this->_Request->input('email');
        $this->Model->User->mobile_phone_number = $this->_Request->input('mobile_phone_number');
        $this->Model->User->password = $this->_Request->input('password');
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'name' => 'required|max:255',
            'username' => 'required|min:12|max:14',
            'email' => 'required|max:255',
            'mobile_phone_number' => 'required|max:255',
            'password' => 'required|max:255'
        ]);
        if ($validator->fails()) {
            $this->Json::set('errors', $validator->errors());
            return false;
        }
        return true;
    }

    public function handle($request, Closure $next)
    {
        $this->Instantiate();
        if($this->Validation()) {
            $this->Payload->put('Model', $this->Model);
            $this->_Request->merge(['Payload' => $this->Payload]);
            return $next($this->_Request);
        } else {
            return response()->json($this->Json::get(), $this->HttpCode);
        }
    }
}
