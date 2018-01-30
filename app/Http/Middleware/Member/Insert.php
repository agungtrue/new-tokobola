<?php

namespace App\Http\Middleware\Member;

use App\Models\User;
use App\Models\Member;
use App\Models\MemberBank;
use App\Models\MemberFamily;
use App\Models\MemberCompany;
use App\Models\Loan;

use Closure;
use App\Http\Middleware\BaseMiddleware;

class Insert extends BaseMiddleware
{
    private function Instantiate()
    {
        $this->Model->User = new User();
        $this->Model->Member = new Member();
        $this->Model->MemberBank = new MemberBank();
        $this->Model->MemberFamily = new MemberFamily();
        $this->Model->MemberCompany = new MemberCompany();
        $this->Model->Loan = new Loan();

        $this->Model->User->name = $this->_Request->input('name');
        $this->Model->User->username = $this->_Request->input('username');
        $this->Model->User->email = $this->_Request->input('email');
        $this->Model->User->password = $this->_Request->input('password');
        $this->Model->User->phone_number = $this->_Request->input('phone_number');

        $this->Model->Member->idcard_number = $this->_Request->input('idcard_number');
        $this->Model->Member->referrer = $this->_Request->input('referrer');
        $this->Model->Member->gender = $this->_Request->input('gender');
        $this->Model->Member->birth_place = $this->_Request->input('birth_place');
        $this->Model->Member->birth_date = $this->_Request->input('birth_date');
        $this->Model->Member->religion = $this->_Request->input('religion');
        $this->Model->Member->ethnic = $this->_Request->input('ethnic');
        $this->Model->Member->domicile_phone_number = $this->_Request->input('domicile_phone_number');
        $this->Model->Member->address = $this->_Request->input('address');
        $this->Model->Member->province = $this->_Request->input('province');
        $this->Model->Member->city = $this->_Request->input('city');
        $this->Model->Member->sub_district = $this->_Request->input('sub_district');
        $this->Model->Member->urban_village = $this->_Request->input('urban_village');
        $this->Model->Member->postal_code = $this->_Request->input('postal_code');
        $this->Model->Member->house_status = $this->_Request->input('house_status');
        $this->Model->Member->relationship_status = $this->_Request->input('relationship_status');
        $this->Model->Member->last_education = $this->_Request->input('last_education');
        $this->Model->Member->dependents = $this->_Request->input('dependents');
        $this->Model->Member->kpr_installment = $this->_Request->input('kpr_installment');
        $this->Model->Member->idcard_image = $this->_Request->input('idcard_image');
        $this->Model->Member->pay_slip_image = $this->_Request->input('pay_slip_image');
        $this->Model->Member->profile_image = $this->_Request->input('profile_image');
        $this->Model->Member->profession = $this->_Request->input('profession');
        $this->Model->Member->work_position = $this->_Request->input('work_position');
        $this->Model->Member->work_start_year = $this->_Request->input('work_start_year');
        $this->Model->Member->work_start_month = $this->_Request->input('work_start_month');
        $this->Model->Member->monthly_income = $this->_Request->input('monthly_income');
        $this->Model->Member->monthly_expenses = $this->_Request->input('monthly_expenses');
        $this->Model->Member->updated_at = $this->_Request->input('updated_at');

        $this->Model->MemberBank->bank = $this->_Request->input('bank');
        $this->Model->MemberBank->bank_account_name = $this->_Request->input('bank_account_name');
        $this->Model->MemberBank->bank_account_number = $this->_Request->input('bank_account_number');

        $this->Model->MemberFamily->family_name = $this->_Request->input('family_name');
        $this->Model->MemberFamily->family_phone_number = $this->_Request->input('family_phone_number');
        $this->Model->MemberFamily->family_address = $this->_Request->input('family_address');
        $this->Model->MemberFamily->family_province = $this->_Request->input('family_province');
        $this->Model->MemberFamily->family_city = $this->_Request->input('family_city');
        $this->Model->MemberFamily->family_sub_district = $this->_Request->input('family_sub_district');
        $this->Model->MemberFamily->family_sub_urban_village = $this->_Request->input('family_sub_urban_village');
        $this->Model->MemberFamily->family_postal_code = $this->_Request->input('family_postal_code');

        $this->Model->MemberCompany->company_name = $this->_Request->input('company_name');
        $this->Model->MemberCompany->company_phone_number = $this->_Request->input('company_phone_number');
        $this->Model->MemberCompany->company_address = $this->_Request->input('company_address');
        $this->Model->MemberCompany->company_provice = $this->_Request->input('company_provice');
        $this->Model->MemberCompany->company_city = $this->_Request->input('company_city');
        $this->Model->MemberCompany->company_sub_district = $this->_Request->input('company_sub_district');
        $this->Model->MemberCompany->company_urban_village = $this->_Request->input('company_urban_village');
        $this->Model->MemberCompany->company_postal_code = $this->_Request->input('company_postal_code');

        $this->Model->Loan->principal = $this->_Request->input('loan_amount');
        $this->Model->Loan->reason = $this->_Request->input('reason');
        $this->Model->Loan->term = $this->_Request->input('term');
    }

    private function Validation()
    {
        if(!$this->Validator::Require($this->_Request->input('name'))) {
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
            return response()->json($this->Json::get(), $this->Json::get('response.code'));
        }
    }
}
