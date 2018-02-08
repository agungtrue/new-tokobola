<?php

namespace App\Http\Middleware\Authentication;

use App\Models\User;

use Closure;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Login extends BaseMiddleware
{
    private function Instantiate()
    {
        $this->email = $this->_Request->input('email');
        $this->password = $this->_Request->input('password');
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'email' => 'required|max:255',
            'password' => 'required|max:255'
        ]);
        if ($validator->fails()) {
            $this->Json::set('errors', $validator->errors());
            return false;
        }
        if (!$this->Model->User = User::where('email', $this->email)->first()) {
            $this->Json::set('errors.email', [
                trans('validation.invalid_json_format')
            ]);
            return false;
        } elseif (!Hash::check($this->password, $this->Model->User->password)) {
            $this->Json::set('errors.password', [
                trans('validation.invalid_json_format')
            ]);
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
