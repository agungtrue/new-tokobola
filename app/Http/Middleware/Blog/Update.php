<?php

namespace App\Http\Middleware\Blog;

use App\Models\User;
use App\Models\Clubs;
use App\Models\Produk;
use App\Models\Blog;


use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class Update extends BaseMiddleware
{
    private function Instantiate()
    {
      $this->Model->Blog = new Blog();
      $this->Model->Blog->judul = $this->_Request->input('judul');
      $this->Model->Blog->konten = $this->_Request->input('konten');
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'judul' => 'required',
            'konten' => 'required'
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
