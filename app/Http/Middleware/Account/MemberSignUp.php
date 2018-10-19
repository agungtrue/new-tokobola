<?php

namespace App\Http\Middleware\Account;

use App\Models\User;
use App\Models\Member;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Http\Middleware\BaseMiddleware;

class MemberSignUp extends BaseMiddleware
{
    private function Instantiate()
    {
        $this->Model->User = new User();
        $this->Model->User->nama_lengkap = $this->_Request->input('nama_lengkap');
        $this->Model->User->username = $this->_Request->input('username');
        $this->Model->User->id_club = $this->_Request->input('id_club');
        $this->Model->User->id_club_negara = $this->_Request->input('id_club_negara');
        $this->Model->User->id_liga = $this->_Request->input('id_liga');
        $this->Model->User->email = $this->_Request->input('email');
        $this->Model->User->gender = $this->_Request->input('gender');
        $this->Model->User->alamat = $this->_Request->input('alamat');
        $this->Model->User->no_hp = $this->_Request->input('no_hp');
        $pass = $this->_Request->input('password');
        $this->Model->User->password = Hash::make($pass);
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'id_club' => 'required',
            'id_club_negara' => 'required',
            'id_liga' => 'required',
            'nama_lengkap' => 'required',
            'email' => 'required|unique:member|max:255',
            'gender' => 'required',
            'alamat' => 'required',
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
