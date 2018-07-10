<?php

namespace App\Http\Controllers\Loan;

use App\Models\Loan;
use App\Models\User;
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
        $Loan = Loan::with('user')
        ->where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where('id', $request->ArrQuery->id);
            }

            if (isset($request->ArrQuery->user_id)) {
                if ($request->ArrQuery->user_id === 'my') {
                    $query->where('user_id', $request->user()->id);
                } else {
                    $query->where('user_id', $request->ArrQuery->user_id);
                }
            }

            if (isset($request->ArrQuery->loans)) {
                    $query->where('id', 'like', '%' . $request->ArrQuery->loans . '%')
                          ->orwhere('term_type', 'like', '%' . $request->ArrQuery->loans . '%')
                          ->orwhere('term', 'like', '%' . $request->ArrQuery->loans . '%')
                          ->orwhere('principal', 'like', '%' . $request->ArrQuery->loans . '%')
                          ->orwhere('interest', 'like', '%' . $request->ArrQuery->loans . '%')
                          ->orwhere('amount', 'like', '%' . $request->ArrQuery->loans . '%')
                          ->orwhere('reason', 'like', '%' . $request->ArrQuery->loans . '%')
                          ->orwhere('status', 'like', '%' . $request->ArrQuery->loans . '%')
                          ->orwhere('payment_status', 'like', '%' . $request->ArrQuery->loans . '%')
                          ->orwhere('due_date', 'like', '%' . $request->ArrQuery->loans . '%')
                          ->orwhere('updated_at', 'like', '%' . $request->ArrQuery->loans . '%')
                          ->orwhere('created_at', 'like', '%' . $request->ArrQuery->loans . '%')
                          ->orwhereHas('user', function ($query) use($request) {
                        $query->where('name', 'like', '%' . $request->ArrQuery->loans . '%')
                              ->orWhere('username', 'like', '%' . $request->ArrQuery->loans . '%');
                    });
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
        // $Model->Loan->interest = $this->interest($Model->Loan->principal, $Model->Loan->term, $Model->Loan->term_type);
        // $Model->Loan->amount = $Model->Loan->principal + $Model->Loan->interest;
        // dd($Model->Loan->user_id);
        $Model->Loan->save();

        event(new ApprovalEvent($request));

        Json::set('data', $Model->Loan);
        return response()->json(Json::get(), 201);
    }

    public function update(Request $request, $id)
    {
        $Loan = Loan::with('user')
                    ->find($id);
        // $Loan->user->name = $request->name;
        // $Loan->user->username = $request->username;
        $Loan->term_type = $request->term_type;
        $Loan->term = $request->term;
        $Loan->principal = $request->principal;
        $Loan->interest = $request->interest;
        $Loan->amount = $request->amount;
        $Loan->reason = $request->reason;
        $Loan->status = $request->status;
        $Loan->payment_status = $request->payment_status;
        // $Loan->due_date = $request->due_date;

        $Loan->save();

        Json::set('data', $Loan);
        return response()->json(Json::get(), 201);

    }

    public function delete(Request $request, $id)
    {
        $Loan = Loan::find($id);
        $Loan->delete();
    }
}
