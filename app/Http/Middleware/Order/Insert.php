<?php

namespace App\Http\Middleware\Order;

use App\Models\User;
use App\Models\Clubs;
use App\Models\Produk;
use App\Models\Blog;
use App\Models\Order;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Insert extends BaseMiddleware
{
    private function Instantiate()
    {
      $this->Model->Order = new Order();
      $this->Model->Order->produk_id = $this->_Request->input('produk_id');
      $this->Model->Order->status = 'unpaid';
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            // 'name' => 'required|unique:clubs',
            'produk_id' => 'required'
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
