<?php

namespace App\Http\Middleware\Club;

use App\Models\Users;
use App\Models\Member;
use App\Models\Clubs;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Insert extends BaseMiddleware
{
    private function Instantiate()
    {
        $this->Model->Club = new Clubs();
        $this->Model->Club->name = $this->_Request->input('name');
        $this->Model->Club->image = $this->_Request->input('image') ? json_decode($this->_Request->input('image')) : null;
        $this->Model->Club->id_liga = $this->_Request->input('id_liga');
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'name' => 'required|unique:clubs',
            'id_liga' => 'required',
            'image' => 'required',

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
