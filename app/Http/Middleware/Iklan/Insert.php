<?php

namespace App\Http\Middleware\Iklan;

use App\Models\User;
use App\Models\Clubs;
use App\Models\Iklan;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Insert extends BaseMiddleware
{
    private function Instantiate()
    {
      $this->Model->Iklan = new Iklan();
      $this->Model->Iklan->nama_produk = $this->_Request->input('nama_produk');
      $this->Model->Iklan->id_member = $this->_Request->input('id_member');
      $this->Model->Iklan->harga_produk = $this->_Request->input('harga_produk');
      $this->Model->Iklan->id_kategori_produk = $this->_Request->input('id_kategori_produk');
      $this->Model->Iklan->id_club = $this->_Request->input('id_club');
      $this->Model->Iklan->spesifikasi = $this->_Request->input('spesifikasi');
      $this->Model->Iklan->gambar_produk = $this->_Request->input('gambar_produk') ? json_decode($this->_Request->input('gambar_produk')) : null;
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            // 'name' => 'required|unique:clubs',
            'nama_produk' => 'required',
            'id_member' => 'required',
            'harga_produk' => 'required',
            'id_kategori_produk' => 'required',
            'spesifikasi' => 'required'

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
