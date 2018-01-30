<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function get(Request $request)
    {
        echo 'get';
    }

    public function create(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->User->save();

        $Model->Member->user_id = $Model->User->id;
        $Model->MemberBank->user_id = $Model->User->id;
        $Model->MemberFamily->user_id = $Model->User->id;
        $Model->MemberCompany->user_id = $Model->User->id;
        $Model->Loan->user_id = $Model->User->id;

        $Model->Member->save();
        $Model->MemberBank->save();
        $Model->MemberFamily->save();
        $Model->MemberCompany->save();

        $interest_percentage = 0.5;
        $Model->Loan->interest = $Model->Loan->principal * ($Model->Loan->term * $interest_percentage) / 100;
        $Model->Loan->amount = $Model->Loan->principal + $Model->Loan->interest;
        $Model->Loan->save();
    }

    public function update(Request $request)
    {
        echo 'update';
    }

    public function delete(Request $request)
    {
        echo 'delete';
    }
}
