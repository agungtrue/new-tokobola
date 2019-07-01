<?php

namespace App\Http\Middleware\Keranjang;

use App\Models\User;
use App\Models\Clubs;
use App\Models\Produk;
use App\Models\Keranjang;
use App\Models\Order;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Insert extends BaseMiddleware
{
    private function Instantiate()
    {
      $this->Model->Keranjang = new Keranjang();
      $this->Model->Keranjang->produk_id = $this->_Request->input('produk_id');
      $this->Model->Keranjang->member_id = $this->_Request->user()->id;
      $this->Model->Keranjang->jumlah = $this->_Request->input('jumlah') ? (int)$this->_Request->input('jumlah') : 1;
      $this->Model->Keranjang->harga_produk = $this->_Request->input('harga_produk');
      $this->Model->Keranjang->total_harga_produk = $this->Model->Keranjang->harga_produk * $this->Model->Keranjang->jumlah;
      $this->Model->Keranjang->keterangan = $this->_Request->input('keterangan');
      // dd($this->Model->Keranjang);
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            // 'name' => 'required|unique:clubs',
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
