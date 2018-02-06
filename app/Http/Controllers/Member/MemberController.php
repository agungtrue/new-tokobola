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

    public function get(Request $request)
    {
        $User = User::with('member')
        ->with('memberBank')
        ->with('memberCompany')
        ->with('memberFamily')
        ->where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where('id', $request->ArrQuery->id);
            }
        });
        $Browse = $this->Browse($request, $User);
        Json::set('data', $Browse);
        return response()->json(Json::get(), 200);
    }

    public function create(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        // Create Password
        $RealPassword = $Model->User->password;
        $Model->User->password = app('hash')->make($RealPassword);
        if (Hash::needsRehash($Model->User->password)) {
            $Model->User->password = app('hash')->make($RealPassword);
        }
        $Model->User->save();

        $Model->Member->user_id = $Model->User->id;
        $Model->MemberBank->user_id = $Model->User->id;
        $Model->MemberFamily->user_id = $Model->User->id;
        $Model->MemberCompany->user_id = $Model->User->id;
        $Model->Loan->user_id = $Model->User->id;

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
        if ($Model->Loan->term_type = 'oncepaid') {
            $interest_percentage = 0.5;
            $Model->Loan->interest = $Model->Loan->principal * ($Model->Loan->term * $interest_percentage) / 100;
            $Model->Loan->amount = $Model->Loan->principal + $Model->Loan->interest;
        }
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

    public function update(Request $request)
    {
        echo 'update';
    }

    public function delete(Request $request)
    {
        echo 'delete';
    }
}
