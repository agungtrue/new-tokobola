<?php

namespace App\Http\Middleware\Liga;

use App\Models\Users;
use App\Models\Member;
use App\Models\Liga;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Update extends BaseMiddleware
{
    private function Instantiate()
    {
        $this->Model->Liga = new Liga();
        $this->Model->Liga->name = $this->_Request->input('name');
        $this->Model->Liga->image = $this->_Request->input('image');
        $this->Model->Liga->id_negara = $this->_Request->input('id_negara');
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'name' => 'required|unique:clubs',
            'id_negara' => 'required'
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
