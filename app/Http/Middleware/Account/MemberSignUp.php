<?php

namespace App\Http\Middleware\Account;

use App\Models\User;
use App\Models\Company;
use App\Models\Member;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class MemberSignUp extends BaseMiddleware
{
    private function Instantiate()
    {
        $this->Model->User = new User();
        $this->Model->Member = new Member();

        $this->Model->User->name = $this->_Request->input('name');
        $this->Model->User->username = $this->_Request->input('username');
        $this->Model->User->email = $this->_Request->input('email');
        $this->Model->User->password = $this->_Request->input('password');
        $this->Model->User->mobile_phone_number = $this->_Request->input('mobile_phone_number');
        !$this->_Request->input('company_id') || $this->Model->Member->company_id = $this->_Request->input('company_id');
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'email' => 'required|unique:users|max:255',
            'password' => 'required|max:255'
        ]);
        if ($validator->fails()) {
            $this->Json::set('errors', $validator->errors());
            return false;
        }
        if ($this->Model->Member->company_id && !Company::where('id', $this->Model->Member->company_id)->first()) {
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
