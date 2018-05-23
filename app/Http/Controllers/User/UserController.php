<?php

namespace App\Http\Controllers\Member;

use App\Models\User;

use App\Support\Response\Json;
use App\Http\Controllers\Controller;
use App\Traits\Browse;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    use Browse;

    public function get(Request $request)
    {
        $User = User::
        where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                if ($request->ArrQuery->id === 'my') {
                    $query->where('id', $request->user()->id);
                } else {
                    $query->where('id', $request->ArrQuery->id);
                }
            }
        });
        $Browse = $this->Browse($request, $User, function ($data) {
            return $data;
        });
        Json::set('data', $Browse);
        return response()->json(Json::get(), 200);
    }
}
