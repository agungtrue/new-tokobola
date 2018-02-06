<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Middleware\BaseMiddleware;

class QueryRoute extends BaseMiddleware
{
    private function Instantiate()
    {
        $this->Query = isset($this->_Request->route()[2]['query']) ? $this->_Request->route()[2]['query'] : null;
        $this->ArrQuery = [];
        if($this->Query) {
            $this->Query = explode('/', $this->Query);
            $this->CountQuery = count($this->Query);
            if( $this->CountQuery%2 == 0 ){
                for ($i = 0; $i < $this->CountQuery; $i++) {
                    if( $i%2 == 0 ){
                        $this->ArrQuery[$this->Query[$i]] = NULL;
                    }
                    if( $i%2 == 1 ){
                        $this->ArrQuery[$this->Query[$i-1]] = urldecode($this->Query[$i]);
                    }
                }
                $this->Param = TRUE;
            }else{
                $this->Param = FALSE;
            }
        } else {
            $this->Param = TRUE;
        }
    }

    private function Validation()
    {
        if (!$this->Param) {

        }
        return true;
    }

    public function handle($request, Closure $next)
    {
        $this->Instantiate();
        if($this->Validation()) {
            if(!array_key_exists('take', $this->ArrQuery)){
                $this->ArrQuery['take'] = (string)10;
            }
            if(!array_key_exists('skip', $this->ArrQuery)){
                $this->ArrQuery['skip'] = (string)0;
            }
            if(array_key_exists('limit', $this->ArrQuery)){
                $this->ArrQuery['take'] = $this->ArrQuery['limit'];
            }
            if(array_key_exists('position', $this->ArrQuery)){
                $this->ArrQuery['skip'] = $this->ArrQuery['position'];
            }
            $this->_Request->merge(['ArrQuery' => (object)$this->ArrQuery]);
            return $next($this->_Request);
        } else {
            return response()->json($this->Json::get(), $this->HttpCode);
        }
    }

}
