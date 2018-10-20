<?php

namespace App\Http\Middleware\Produk;

use App\Models\User;
use App\Models\Clubs;
use App\Models\Produk;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Insert extends BaseMiddleware
{
    private function Instantiate()
    {
      $this->Model->Produk = new Produk();
      $this->Model->Produk->nama_produk = $this->_Request->input('nama_produk');
      $this->Model->Produk->harga_produk = $this->_Request->input('harga_produk');
      $this->Model->Produk->id_kategori_produk = $this->_Request->input('id_kategori_produk');
      $this->Model->Produk->spesifikasi_produk = $this->_Request->input('spesifikasi_produk');
      $this->Model->Produk->images = $this->_Request->input('images');
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            // 'name' => 'required|unique:clubs',
            'nama_produk' => 'required',
            'harga_produk' => 'required',
            'id_kategori_produk' => 'required',
            'spesifikasi_produk' => 'required'

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
