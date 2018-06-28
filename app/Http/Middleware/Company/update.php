<?php

namespace App\Http\Middleware\Company;

use App\Models\Company;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Update extends BaseMiddleware
{
    private function Instantiate()
    {
        $this->Model->Company = new Company();

        $this->Model->Company->name = $this->_Request->input('name');
        $this->Model->Company->phone_number = $this->_Request->input('phone_number');
        $this->Model->Company->address = $this->_Request->input('address');
        $this->Model->Company->province = $this->_Request->input('province');
        $this->Model->Company->city = $this->_Request->input('city');
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'name' => 'required|max:255',
            'phone_number' => 'required|min:12|max:14',
            'address' => 'required|max:255',
            'province' => 'required|max:255',
            'city' => 'required|max:255'
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
