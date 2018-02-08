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

        Json::set('data', [
            'email' => $Model->User->email,
            'oauth' => [
                'token_type' => 'Bearer',
                'access_token' => $Model->User->createToken('SignUp')->accessToken
            ]
        ]);
        return response()->json(Json::get(), 201);
    }
}
