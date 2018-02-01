<?php

namespace App\Http\Middleware\Image;

use Closure;
use App\Http\Middleware\BaseMiddleware;

class Upload extends BaseMiddleware
{
    private function Instantiate()
    {
        $this->Image = $this->_Request->file('image');
    }

    private function Validation()
    {
        if (!$this->Validator::Require($this->Image)) {
            $this->Json::set('response.code', 400);
            $this->Json::set('exception.code', 'EmptyImage');
            $this->Json::set('exception.message', trans('Equinox::Validation.'.$this->Json::get('exception.code')));
            return false;
        } elseif (!$this->Validator::CheckMimeType($this->Image->getMimeType())) {
            $this->Json::set('response.code', 400);
            $this->Json::set('exception.code', 'InvalidImage');
            $this->Json::set('exception.message', trans('Equinox::Validation.'.$this->Json::get('exception.code')));
            return false;
        }
        return true;
    }

    public function handle($request, Closure $next)
    {
        $this->Instantiate();
        if($this->Validation()) {
            $this->Payload->put('Image', $this->Image);
            $this->_Request->merge(['Payload' => $this->Payload]);
            return $next($this->_Request);
        } else {
            return response()->json($this->Json::get(), $this->Json::get('response.code'));
        }
    }
}
