<?php

namespace App\Http\Controllers\Authentication;

use App\Models\User;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use App\Http\Controllers\Controller;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        Json::set('data', [
            'email' => $Model->User->email,
            'oauth' => [
                'token_type' => 'Bearer',
                'access_token' => $Model->User->createToken('Login')->accessToken
            ]
        ]);
        return response()->json(Json::get(), 201);
    }
}
