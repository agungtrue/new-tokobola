<?php

namespace App\Http\Middleware\Loan;

use App\Models\Loan;

use Closure;
use Validator;
use App\Http\Middleware\BaseMiddleware;

class Insert extends BaseMiddleware
{
    private function Instantiate()
    {
        $this->Model->Loan = new Loan();
        !$this->_Request->input('principal') || $this->Model->Loan->principal = $this->_Request->input('principal');
        !$this->_Request->input('loan_amount') || $this->Model->Loan->principal = $this->_Request->input('loan_amount');
        $this->Model->Loan->term_type = $this->_Request->input('term_type');
        $this->Model->Loan->term = $this->_Request->input('term');
        $this->Model->Loan->reason = $this->_Request->input('reason');
    }

    private function Validation()
    {
      $rules = [
          'term' => 'required',
          'term_type' => 'required'
      ];
      if ($this->_Request->input('loan_amount')) {
        $rules['loan_amount'] = 'required';
      } else {
        $rules['principal'] = 'required';
      }
        $validator = Validator::make($this->_Request->all(), $rules);
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
