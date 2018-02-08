<?php

namespace App\Http\Middleware\Member;

use App\Models\User;
use App\Models\Member;
use App\Models\MemberBank;
use App\Models\MemberFamily;
use App\Models\MemberCompany;
use App\Models\Loan;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

class UpdateMy extends BaseMiddleware
{
    private function Instantiate()
    {
        $this->Model->User = $this->_Request->user();
        $this->Model->Member = Member::find($this->Model->User->id);
        $this->Model->MemberBank = MemberBank::firstOrNew(['user_id' => $this->Model->User->id]);
        $this->Model->MemberFamily = MemberFamily::firstOrNew(['user_id' => $this->Model->User->id]);
        $this->Model->MemberCompany = MemberCompany::firstOrNew(['user_id' => $this->Model->User->id]);
        $this->Model->User->name = $this->_Request->input('name');
        $this->Model->User->mobile_phone_number = $this->_Request->input('mobile_phone_number');
        $this->Model->Member->phone_number = $this->_Request->input('phone_number');
        $this->Model->Member->idcard_number = $this->_Request->input('idcard_number');
        $this->Model->Member->referrer = $this->_Request->input('referrer');
        $this->Model->Member->gender = $this->_Request->input('gender');
        $this->Model->Member->birth_place = $this->_Request->input('birth_place');
        $this->Model->Member->birth_date = $this->_Request->input('birth_date');
        $this->Model->Member->religion = $this->_Request->input('religion');
        $this->Model->Member->citizenship = $this->_Request->input('citizenship');
        $this->Model->Member->address = $this->_Request->input('address');
        $this->Model->Member->province = $this->_Request->input('province');
        $this->Model->Member->city = $this->_Request->input('city');
        $this->Model->Member->sub_district = $this->_Request->input('sub_district');
        $this->Model->Member->urban_village = $this->_Request->input('urban_village');
        $this->Model->Member->postal_code = $this->_Request->input('postal_code');
        $this->Model->Member->neighbourhood = $this->_Request->input('neighbourhood');
        $this->Model->Member->hamlet = $this->_Request->input('hamlet');
        $this->Model->Member->house_status = $this->_Request->input('house_status');
        $this->Model->Member->idcard_address = $this->_Request->input('idcard_address');
        $this->Model->Member->idcard_province = $this->_Request->input('idcard_province');
        $this->Model->Member->idcard_city = $this->_Request->input('idcard_city');
        $this->Model->Member->idcard_sub_district = $this->_Request->input('idcard_sub_district');
        $this->Model->Member->idcard_urban_village = $this->_Request->input('idcard_urban_village');
        $this->Model->Member->idcard_neighbourhood = $this->_Request->input('idcard_neighbourhood');
        $this->Model->Member->idcard_hamlet = $this->_Request->input('idcard_hamlet');
        $this->Model->Member->idcard_postal_code = $this->_Request->input('idcard_postal_code');
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
        $this->Model->MemberBank->bank_branch = $this->_Request->input('bank_branch');
        $this->Model->MemberBank->bank_account_name = $this->_Request->input('bank_account_name');
        $this->Model->MemberBank->bank_account_number = $this->_Request->input('bank_account_number');
        $this->Model->MemberFamily->family_name = $this->_Request->input('family_name');
        $this->Model->MemberFamily->family_mobile_phone_number = $this->_Request->input('family_mobile_phone_number');
        $this->Model->MemberFamily->family_phone_number = $this->_Request->input('family_phone_number');
        $this->Model->MemberFamily->family_address = $this->_Request->input('family_address');
        $this->Model->MemberFamily->family_province = $this->_Request->input('family_province');
        $this->Model->MemberFamily->family_city = $this->_Request->input('family_city');
        $this->Model->MemberFamily->family_sub_district = $this->_Request->input('family_sub_district');
        $this->Model->MemberFamily->family_urban_village = $this->_Request->input('family_urban_village');
        $this->Model->MemberFamily->family_postal_code = $this->_Request->input('family_postal_code');
        $this->Model->MemberFamily->family_neighbourhood = $this->_Request->input('family_neighbourhood');
        $this->Model->MemberFamily->family_hamlet = $this->_Request->input('family_hamlet');
        $this->Model->MemberCompany->company_name = $this->_Request->input('company_name');
        $this->Model->MemberCompany->company_phone_number = $this->_Request->input('company_phone_number');
        $this->Model->MemberCompany->company_address = $this->_Request->input('company_address');
        $this->Model->MemberCompany->company_province = $this->_Request->input('company_province');
        $this->Model->MemberCompany->company_city = $this->_Request->input('company_city');
        $this->Model->MemberCompany->company_sub_district = $this->_Request->input('company_sub_district');
        $this->Model->MemberCompany->company_urban_village = $this->_Request->input('company_urban_village');
        $this->Model->MemberCompany->company_postal_code = $this->_Request->input('company_postal_code');
        $this->Model->MemberCompany->company_neighbourhood = $this->_Request->input('company_neighbourhood');
        $this->Model->MemberCompany->company_hamlet = $this->_Request->input('company_hamlet');
        $this->IDCardImage = $this->_Request->input('idcard_image') ? json_decode($this->_Request->input('idcard_image')) : null;
        $this->PaySlipImage = $this->_Request->input('pay_slip_image') ? json_decode($this->_Request->input('pay_slip_image')) : null;
        $this->ProfileImage = $this->_Request->input('profile_image') ? json_decode($this->_Request->input('profile_image')) : null;
    }

    private function Validation()
    {
        $validator = Validator::make($this->_Request->all(), [
            'name' => 'required|max:255',
            'mobile_phone_number' => 'required|min:10|max:14',
            'phone_number' => 'required|min:10|max:14',
            'idcard_number' => 'required|min:16|max:16',
            'reason' => 'required',
            'gender' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required',
            'religion' => 'required',
            'citizenship' => 'required',
            'relationship_status' => 'required',
            'last_education' => 'required',
            'dependents' => 'required',
            'address' => 'required',
            'province' => 'required',
            'city' => 'required',
            'sub_district' => 'required',
            'urban_village' => 'required',
            'postal_code' => 'required',
            'neighbourhood' => 'required',
            'hamlet' => 'required',
            'house_status' => 'required',
            'idcard_address' => 'required',
            'idcard_province' => 'required',
            'idcard_city' => 'required',
            'idcard_sub_district' => 'required',
            'idcard_urban_village' => 'required',
            'idcard_neighbourhood' => 'required',
            'idcard_hamlet' => 'required',
            'idcard_postal_code' => 'required',
            'family_name' => 'required',
            'family_mobile_phone_number' => 'required',
            'family_phone_number' => 'required',
            'family_address' => 'required',
            'family_province' => 'required',
            'family_city' => 'required',
            'family_sub_district' => 'required',
            'family_urban_village' => 'required',
            'family_postal_code' => 'required',
            'family_neighbourhood' => 'required',
            'family_hamlet' => 'required',
            'bank' => 'required',
            'bank_branch' => 'required',
            'bank_account_name' => 'required',
            'bank_account_number' => 'required',
            'company_name' => 'required',
            'company_phone_number' => 'required|min:10|max:14',
            'company_address' => 'required',
            'company_province' => 'required',
            'company_city' => 'required',
            'company_sub_district' => 'required',
            'company_urban_village' => 'required',
            'company_postal_code' => 'required',
            'company_neighbourhood' => 'required',
            'company_hamlet' => 'required',
            'profession' => 'required',
            'work_position' => 'required',
            'work_start_year' => 'required',
            'work_start_month' => 'required',
            'monthly_income' => 'required',
            'monthly_expenses' => 'required',
            'kpr_installment' => 'required'
        ]);
        if ($validator->fails()) {
            $this->Json::set('errors', $validator->errors());
            return false;
        }

        if ($this->IDCardImage) {
            if (isset($this->IDCardImage->key) && isset($this->IDCardImage->extension)) {
                $this->IDCardImage->original = $this->IDCardImage->key . '-original.' . $this->IDCardImage->extension;
                $this->IDCardImage->small = $this->IDCardImage->key . '-small.' . $this->IDCardImage->extension;
                if (!Storage::disk('temporary')->exists($this->IDCardImage->original) || !Storage::disk('temporary')->exists($this->IDCardImage->small)) {
                    $this->Json::set('errors.idcard_image', [
                        trans('validation.invalid_json_format', ['attribute' => $this->transAttribute('idcard_image')])
                    ]);
                    return false;
                }
                $this->Payload->put('IDCardImage', $this->IDCardImage);
            } else {
                $this->Json::set('errors.idcard_image', [
                    trans('validation.invalid_json_format', ['attribute' => $this->transAttribute('idcard_image')])
                ]);
                return false;
            }
        }
        if ($this->PaySlipImage) {
            if (isset($this->PaySlipImage->key) && isset($this->PaySlipImage->extension)) {
                $this->PaySlipImage->original = $this->PaySlipImage->key . '-original.' . $this->PaySlipImage->extension;
                $this->PaySlipImage->small = $this->PaySlipImage->key . '-small.' . $this->PaySlipImage->extension;
                if (!Storage::disk('temporary')->exists($this->PaySlipImage->original) || !Storage::disk('temporary')->exists($this->PaySlipImage->small)) {
                    $this->Json::set('errors.idcard_image', [
                        trans('validation.invalid_json_format', ['attribute' => $this->transAttribute('pay_slip_image')])
                    ]);
                    return false;
                }
                $this->Payload->put('PaySlipImage', $this->PaySlipImage);
            } else {
                $this->Json::set('errors.idcard_image', [
                    trans('validation.invalid_json_format', ['attribute' => $this->transAttribute('pay_slip_image')])
                ]);
                return false;
            }
        }
        if ($this->ProfileImage) {
            if (isset($this->ProfileImage->key) && isset($this->ProfileImage->extension)) {
                $this->ProfileImage->original = $this->ProfileImage->key . '-original.' . $this->ProfileImage->extension;
                $this->ProfileImage->small = $this->ProfileImage->key . '-small.' . $this->ProfileImage->extension;
                if (!Storage::disk('temporary')->exists($this->ProfileImage->original) || !Storage::disk('temporary')->exists($this->ProfileImage->small)) {
                    $this->Json::set('errors.pay_slip_image', [
                        trans('validation.invalid_json_format', ['attribute' => $this->transAttribute('profile_image')])
                    ]);
                    return false;
                }
                $this->Payload->put('ProfileImage', $this->ProfileImage);
            } else {
                $this->Json::set('errors.profile_image', [
                    trans('validation.invalid_json_format', ['attribute' => $this->transAttribute('profile_image')])
                ]);
                return false;
            }
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
