<?php

namespace App\Http\Middleware\Keranjang;

use App\Models\User;
use App\Models\Clubs;
use App\Models\Produk;
use App\Models\Keranjang;


use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Update extends BaseMiddleware
{
    private function Instantiate()
    {
      $this->Model->Keranjang = new Keranjang();
      $this->Model->Keranjang->jumlah = $this->_Request->input('jumlah');
      $this->Model->Keranjang->keterangan = $this->_Request->input('keterangan');
      // dd($this->Model->Keranjang);
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [

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
