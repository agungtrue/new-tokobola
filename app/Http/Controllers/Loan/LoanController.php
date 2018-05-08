<?php

namespace App\Http\Controllers\Loan;

use App\Models\Loan;
use App\Support\Response\Json;
use App\Http\Controllers\Controller;

use App\Traits\Browse;
use App\Traits\LoanFormula;

use Illuminate\Http\Response;
use Illuminate\Http\Request;

// Events
use App\Events\Loan\Approval as ApprovalEvent;

class LoanController extends Controller
{
    use Browse, LoanFormula;

    public function get(Request $request)
    {
        $Loan = Loan::
        where(function ($query) use($request) {
            if (isset($request->ArrQuery->user_id)) {
                if ($request->ArrQuery->user_id === 'my') {
                    $query->where('user_id', $request->user()->id);
                } else {
                    $query->where('user_id', $request->ArrQuery->user_id);
                }
            }
        });
        $Browse = $this->Browse($request, $Loan);
        Json::set('data', $Browse);
        return response()->json(Json::get(), 200);
    }

    public function create(Request $request)
    {
        $this->request = $request;
        $Model = $request->Payload->all()['Model'];

        $Model->Loan->interest = $this->interest($Model->Loan->principal, $Model->Loan->term, $Model->Loan->term_type);
        $Model->Loan->amount = $Model->Loan->principal + $Model->Loan->interest;

        $Model->Loan->save();

        event(new ApprovalEvent($request));

        Json::set('data', $Model->Loan);
        return response()->json(Json::get(), 201);
    }
}
