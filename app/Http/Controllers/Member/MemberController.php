<?php

namespace App\Http\Controllers\Member;

use App\Models\User;
use App\Models\Image;
use App\Support\Response\Json;
use App\Http\Controllers\Controller;
use App\Traits\Browse;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    use Browse;

    private function setMemberImage($data, $ImagesData) {
        $Path = config('filesystems.disks.s3.host') . config('filesystems.disks.s3.ImagesDirectory');

        $ImagesList = [
            'idcard' => 'idcard_image',
            'pay_slip' => 'pay_slip_image',
            'family_card' => 'family_card_image',
            'profile' => 'profile_image'
        ];

        $data->map(function($item) use ($ImagesData, $ImagesList, $Path) {
            $images = [];
            foreach ($ImagesList as $key => $imageValue) {
                if (isset($item->member) && isset($item->member->{$imageValue}) && isset($ImagesData[$item->member->{$imageValue}])) {
                    $Image = $ImagesData[$item->member->{$imageValue}];
                    $images[$key] = [
                        'id' => $Image->_id,
                        'small' => [
                            'url' => $Path . $Image->key . '-small.' . $Image->extension
                        ],
                        'original' => [
                            'url' => $Path . $Image->key . '-original.' . $Image->extension
                        ]
                    ];
                }
            }
            $item->member->images = $images;
            return $item;
        });
        return $data;
    }

    public function get(Request $request)
    {
        $User = User::with('member')
        ->with('memberBank')
        ->with('memberCompany')
        ->with('memberFamily')
        ->where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                if ($request->ArrQuery->id === 'my') {
                    $query->where('id', $request->user()->id);
                } else {
                    $query->where('id', $request->ArrQuery->id);
                }
            }
            if (isset($request->ArrQuery->members)) {
                    $query->whereHas('member', function ($query) use($request) {
                        $query->where('user_id', 'like', '%' . $request->ArrQuery->members . '%')
                              ->orWhere('idcard_number', 'like', '%' . $request->ArrQuery->members . '%')
                              ->orWhere('npwp_number', 'like', '%' . $request->ArrQuery->members . '%')
                              ->orWhere('referrer', 'like', '%' . $request->ArrQuery->members . '%')
                              ->orWhere('gender', 'like', $request->ArrQuery->members . '%')
                              ->orWhere('birth_place', 'like', '%' . $request->ArrQuery->members . '%')
                              ->orWhere('birth_date', 'like', '%' . $request->ArrQuery->members . '%')
                              ->orWhere('religion', 'like', '%' . $request->ArrQuery->members . '%')
                              ->orWhere('citizenship', 'like', '%' . $request->ArrQuery->members . '%')
                              ->orWhere('phone_number', 'like', '%' . $request->ArrQuery->members . '%')
                              ->orWhere('address', 'like', '%' . $request->ArrQuery->members . '%')
                              ->orWhere('province', 'like', '%' . $request->ArrQuery->members . '%')
                              ->orWhere('city', 'like', '%' . $request->ArrQuery->members . '%')
                              ->orWhere('username', 'like', '%' . $request->ArrQuery->members . '%')
                              ->orWhere('sub_district', 'like', '%' . $request->ArrQuery->members . '%');
                    });
            }

            if (isset($request->ArrQuery->search)) {
                $query->where('id', 'like', '%' . $request->ArrQuery->search . '%')
                      ->orWhere('name', 'like', '%' . $request->ArrQuery->search . '%')
                      ->orWhere('username', 'like', '%' . $request->ArrQuery->search . '%')
                      ->orWhere('email', 'like', '%' . $request->ArrQuery->search . '%')
                      ->orWhere('mobile_phone_number', 'like', '%' . $request->ArrQuery->search . '%')
                      ->orWhere('password', 'like', '%' . $request->ArrQuery->search . '%')
                      ->orWhere('remember_token', 'like', '%' . $request->ArrQuery->search . '%')
                      ->orWhere('updated_at', 'like', '%' . $request->ArrQuery->search . '%')
                      ->orWhere('created_at', 'like', '%' . $request->ArrQuery->search . '%')
                      ->orWhere('deleted_at', 'like', '%' . $request->ArrQuery->search . '%');
            }

        });
        $Browse = $this->Browse($request, $User, function ($data) {
            $Images = collect([]);
            $AllImages = $Images
                ->concat($data->pluck('member.idcard_image')->toArray())
                ->concat($data->pluck('member.pay_slip_image')->toArray())
                ->concat($data->pluck('member.family_card_image')->toArray())
                ->concat($data->pluck('member.profile_image')->toArray());
            $ImagesData = Image::whereIn('_id', $AllImages->toArray())->get();
            $this->setMemberImage($data, $ImagesData->keyBy('_id'));
            return $data;
        });
        Json::set('data', $Browse);
        return response()->json(Json::get(), 200);
    }

    public function create(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        // dd($Model);
        // Create Password
        $RealPassword = $Model->User->password;
        $Model->User->password = app('hash')->make($RealPassword);
        if (Hash::needsRehash($Model->User->password)) {
            $Model->User->password = app('hash')->make($RealPassword);
        }

        if (isset($request->Payload->all()['IDCardImage']) && $IDCardImage = $request->Payload->all()['IDCardImage']) {
            Storage::disk('s3')->put(config('filesystems.disks.s3.ImagesDirectory').$IDCardImage->original,
            Storage::disk('temporary')->get($IDCardImage->original), 'public');

            Storage::disk('s3')->put(config('filesystems.disks.s3.ImagesDirectory').$IDCardImage->small,
            Storage::disk('temporary')->get($IDCardImage->small), 'public');
            $CollectionImage = new Image();
            $CollectionImage->key = $IDCardImage->key;
            $CollectionImage->extension = $IDCardImage->extension;
            $CollectionImage->user_id = $Model->User->id;
            $CollectionImage->save();
            $Model->Member->idcard_image = $CollectionImage->id;
        }
        if (isset($request->Payload->all()['PaySlipImage']) && $PaySlipImage = $request->Payload->all()['PaySlipImage']) {
            Storage::disk('s3')->put(config('filesystems.disks.s3.ImagesDirectory').$PaySlipImage->original,
            Storage::disk('temporary')->get($PaySlipImage->original), 'public');

            Storage::disk('s3')->put(config('filesystems.disks.s3.ImagesDirectory').$PaySlipImage->small,
            Storage::disk('temporary')->get($PaySlipImage->small), 'public');
            $CollectionImage = new Image();
            $CollectionImage->key = $PaySlipImage->key;
            $CollectionImage->extension = $PaySlipImage->extension;
            $CollectionImage->user_id = $Model->User->id;
            $CollectionImage->save();
            $Model->Member->pay_slip_image = $CollectionImage->id;
        }
        if (isset($request->Payload->all()['ProfileImage']) && $ProfileImage = $request->Payload->all()['ProfileImage']) {
            Storage::disk('s3')->put(config('filesystems.disks.s3.ImagesDirectory').$ProfileImage->original,
            Storage::disk('temporary')->get($ProfileImage->original), 'public');

            Storage::disk('s3')->put(config('filesystems.disks.s3.ImagesDirectory').$ProfileImage->small,
            Storage::disk('temporary')->get($ProfileImage->small), 'public');
            $CollectionImage = new Image();
            $CollectionImage->key = $ProfileImage->key;
            $CollectionImage->extension = $ProfileImage->extension;
            $CollectionImage->user_id = $Model->User->id;
            $CollectionImage->save();
            $Model->Member->profile_image = $CollectionImage->id;
        }

        if ($Model->Loan->term_type = 'oncepaid') {
            $interest_percentage = 0.5;
            $Model->Loan->interest = $Model->Loan->principal * ($Model->Loan->term * $interest_percentage) / 100;
            $Model->Loan->amount = $Model->Loan->principal + $Model->Loan->interest;
        }
        // if ($Model->Loan->term_type = 'oncepaid') {
        //     $interest_percentage = 0.5;
        //     $Model->Loan->interest = $Model->Loan->principal * ($Model->Loan->term * $interest_percentage) / 100;
        //     $Model->Loan->amount = $Model->Loan->principal + $Model->Loan->interest;
        // }
        if ($Model->Loan->term_type = 'installments') {
            $interest_percentage = 15;
            $Model->Loan->interest = $Model->Loan->principal * ($Model->Loan->term * $interest_percentage) / 100;
            $Model->Loan->amount = $Model->Loan->principal + $Model->Loan->interest;
        }

        $Model->Member->save();
        $Model->MemberBank->save();
        $Model->MemberFamily->save();
        $Model->MemberCompany->save();
        $Model->Loan->save();
        return response()->json(Json::get(), 201);
    }

    public function update(Request $request, $id)
    {
        // $Model = $request->Payload->all()['Model'];
        $Model = User::find($id);

        $Model->name = $request->name;
        $Model->username = $request->username;
        $Model->email = $request->email;
        $Model->mobile_phone_number = $request->mobile_phone_number;

        $Model->Member->address = $request->address;
        $Model->Member->idcard_number = $request->idcard_number;
        $Model->Member->referrer = $request->referrer;
        $Model->Member->gender = $request->gender;
        $Model->Member->birth_place = $request->birth_place;
        $Model->Member->birth_date = $request->birth_date;
        $Model->Member->religion = $request->religion;
        $Model->Member->province = $request->province;
        $Model->Member->city = $request->city;
        $Model->Member->sub_district = $request->sub_district;
        $Model->Member->urban_village = $request->urban_village;
        $Model->Member->postal_code = $request->postal_code;
        $Model->Member->house_status = $request->house_status;
        $Model->Member->relationship_status = $request->relationship_status;
        $Model->Member->last_education = $request->last_education;
        $Model->Member->dependents = $request->dependents;
        $Model->Member->kpr_installment = $request->kpr_installment;
        $Model->Member->profession = $request->profession;
        $Model->Member->work_position = $request->work_position;
        $Model->Member->work_start_year = $request->work_start_year;
        $Model->Member->work_start_month = $request->work_start_month;
        $Model->Member->monthly_income = $request->monthly_income;
        $Model->Member->monthly_expenses = $request->monthly_expenses;
        $Model->Member->phone_number = $request->phone_number;
        $Model->Member->citizenship = $request->citizenship;
        $Model->Member->npwp_number = $request->npwp_number;

        // dd($Model->mobile_phone_number);

        $Model->save();
        $Model->Member->save();
        // $Model->MemberBank->save();
        // $Model->MemberFamily->save();
        // $Model->MemberCompany->save();
        return response()->json(Json::get(), 201);

        // echo 'update';
    }

    public function updateMy(Request $request)
    {
        $Model = $request->Payload->all()['Model'];

        if (isset($request->Payload->all()['IDCardImage']) && $IDCardImage = $request->Payload->all()['IDCardImage']) {
            Storage::disk('s3')->put(config('filesystems.disks.s3.ImagesDirectory').$IDCardImage->original,
            Storage::disk('temporary')->get($IDCardImage->original), 'public');

            Storage::disk('s3')->put(config('filesystems.disks.s3.ImagesDirectory').$IDCardImage->small,
            Storage::disk('temporary')->get($IDCardImage->small), 'public');
            $CollectionImage = new Image();
            $CollectionImage->key = $IDCardImage->key;
            $CollectionImage->extension = $IDCardImage->extension;
            $CollectionImage->user_id = $Model->User->id;
            $CollectionImage->save();
            $Model->Member->idcard_image = $CollectionImage->id;
        }
        if (isset($request->Payload->all()['PaySlipImage']) && $PaySlipImage = $request->Payload->all()['PaySlipImage']) {
            Storage::disk('s3')->put(config('filesystems.disks.s3.ImagesDirectory').$PaySlipImage->original,
            Storage::disk('temporary')->get($PaySlipImage->original), 'public');

            Storage::disk('s3')->put(config('filesystems.disks.s3.ImagesDirectory').$PaySlipImage->small,
            Storage::disk('temporary')->get($PaySlipImage->small), 'public');
            $CollectionImage = new Image();
            $CollectionImage->key = $PaySlipImage->key;
            $CollectionImage->extension = $PaySlipImage->extension;
            $CollectionImage->user_id = $Model->User->id;
            $CollectionImage->save();
            $Model->Member->pay_slip_image = $CollectionImage->id;
        }
        if (isset($request->Payload->all()['ProfileImage']) && $ProfileImage = $request->Payload->all()['ProfileImage']) {
            Storage::disk('s3')->put(config('filesystems.disks.s3.ImagesDirectory').$ProfileImage->original,
            Storage::disk('temporary')->get($ProfileImage->original), 'public');

            Storage::disk('s3')->put(config('filesystems.disks.s3.ImagesDirectory').$ProfileImage->small,
            Storage::disk('temporary')->get($ProfileImage->small), 'public');
            $CollectionImage = new Image();
            $CollectionImage->key = $ProfileImage->key;
            $CollectionImage->extension = $ProfileImage->extension;
            $CollectionImage->user_id = $Model->User->id;
            $CollectionImage->save();
            $Model->Member->profile_image = $CollectionImage->id;
        }
        if (isset($request->Payload->all()['FamilyCardImage']) && $FamilyCardImage = $request->Payload->all()['FamilyCardImage']) {
            Storage::disk('s3')->put(config('filesystems.disks.s3.ImagesDirectory').$FamilyCardImage->original,
            Storage::disk('temporary')->get($FamilyCardImage->original), 'public');

            Storage::disk('s3')->put(config('filesystems.disks.s3.ImagesDirectory').$FamilyCardImage->small,
            Storage::disk('temporary')->get($FamilyCardImage->small), 'public');
            $CollectionImage = new Image();
            $CollectionImage->key = $FamilyCardImage->key;
            $CollectionImage->extension = $FamilyCardImage->extension;
            $CollectionImage->user_id = $Model->User->id;
            $CollectionImage->save();
            $Model->Member->family_card_image = $CollectionImage->id;
        }

        $Model->User->save();
        $Model->Member->save();
        $Model->MemberBank->save();
        $Model->MemberFamily->save();
        $Model->MemberCompany->save();
        return response()->json(Json::get(), 201);
    }

    public function delete(Request $request, $id)
    {
        $User = User::find($id);
        $User->delete();
    }
}
