<?php

namespace App\Http\Controllers\Loan;

use App\Models\Loan;
use App\Support\Response\Json;
use App\Http\Controllers\Controller;
use App\Traits\Browse;

use Illuminate\Http\Response;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    use Browse;

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
        $Model = $request->Payload->all()['Model'];

        if ($Model->Loan->term_type === 'oncepaid') {
            $interest_percentage = 1;
            $Model->Loan->interest = $Model->Loan->principal * ($Model->Loan->term * $interest_percentage) / 100;
            $Model->Loan->amount = $Model->Loan->principal + $Model->Loan->interest;
        }
        if ($Model->Loan->term_type === 'installments') {
            $interest_percentage = 15;
            $Model->Loan->interest = $Model->Loan->principal * ($Model->Loan->term * $interest_percentage) / 100;
            $Model->Loan->amount = $Model->Loan->principal + $Model->Loan->interest;
        }

        $Model->Loan->save();
        return response()->json(Json::get(), 201);
    }
}
