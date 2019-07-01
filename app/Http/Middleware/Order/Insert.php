<?php

namespace App\Http\Middleware\Order;

use App\Models\User;
use App\Models\Clubs;
use App\Models\Produk;
use App\Models\Blog;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Keranjang;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Insert extends BaseMiddleware
{
    private function Instantiate()
    {
      $this->Model->Order = new Order();
      $this->Model->Order->member_id = $this->_Request->user()->id;
      $this->Model->Order->keranjang_id = $this->_Request->input('keranjang_id');
      $this->Model->Order->alamat_pengiriman = $this->_Request->input('alamat_pengiriman');
      $this->Model->Order->status = 'unpaid';
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            // 'keranjang_id' => 'required'
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
