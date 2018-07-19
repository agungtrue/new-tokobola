<?php

namespace App\Http\Controllers\Account;

use App\Models\User;
use App\Models\Image;
use App\Support\Response\Json;
use App\Http\Controllers\Controller;
use App\Traits\Browse;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

// Events
use App\Events\NewUserRegistration;

class AccountController extends Controller
{
    public function memberSignUp(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $RealPassword = $Model->User->password;
        $Model->User->password = app('hash')->make($RealPassword);
        if (Hash::needsRehash($Model->User->password)) {
            $Model->User->password = app('hash')->make($RealPassword);
        }
        $Model->User->save();

        $Model->Member->user_id = $Model->User->id;
        $Model->Member->save();

        // PUSH EVENT
        event(new NewUserRegistration($request));

        Json::set('data', [
            'email' => $Model->User->email,
            'oauth' => [
                'token_type' => 'Bearer',
                'access_token' => $Model->User->createToken('SignUp')->accessToken
            ]
        ]);
        return response()->json(Json::get(), 201);
    }

    public function update(Request $request, $id)
    {
        $User = User::find($id);
        // dd($request->name);
        $User->name = $request->name;
        $User->email = $request->email;
        $User->username = $request->username;
        $User->mobile_phone_number = $request->mobile_phone_number;
        // $User->amount = $request->amount;

        $User->save();

        Json::set('data', $User);
        return response()->json(Json::get(), 201);

    }
}
