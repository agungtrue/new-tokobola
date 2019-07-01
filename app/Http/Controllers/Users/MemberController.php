<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Support\Response\Json;
use App\Traits\Browse;

use App\Models\User;
use App\Models\Produk;
use App\Models\Clubs;
use App\Models\Liga;
use App\Models\Negara;



class MemberController extends Controller
{
    use Browse;

    public function get(Request $request)
    {

      $Member = User::with('negara_klub', 'liga', 'club', 'order')
      ->where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where('id', $request->ArrQuery->id);
            }

            if (isset($request->ArrQuery->member_id)) {
                if ($request->ArrQuery->member_id === 'my') {
                    $query->where('id', $request->user()->id);
                } else {
                    $query->where('id', $request->ArrQuery->id);
                }
            }

            if (isset($request->ArrQuery->memberRegis)) {
                $query->where('created_at', 'like', '%' . $request->ArrQuery->memberRegis . '%');
            }
        });



      // $users = $users->map(function($user) {
      //   if ($user->gender === 'L') {
      //     $user->alamat .= ' A';
      //   }
      //   return $user;
      // });

      // $users = $users->map(function($user) {
      //   $user->greeting = 'adada';
      //   return $user;
      // });

      $Browse = $this->Browse($request, $Member, function ($data) {
          return $data;
      });

      Json::set('data', $Browse);
      return response()->json(Json::get(), 200);

    }

    public function update(Request $request, $id)
    {
        // $Model = $request->Payload->all()['Model'];
        $Model = User::find($id);
        $Model->nama_lengkap = $request->nama_lengkap;
        $Model->email = $request->email;
        $Model->alamat = $request->alamat;
        $Model->username = $request->username;
        $Model->no_hp = $request->no_hp;
        $Model->foto_profile = $request->foto_profile ? json_decode($request->foto_profile) : null;

        if (isset($Model->foto_profile)) {
            if ($Model->foto_profile->extension !== 'pdf') {
                Storage::disk('public')->put('/images/fotoProfile/' . $Model->foto_profile->original, Storage::disk('temporary')->get($Model->foto_profile->original), 'public');
            }
            $Model->foto_profile = 'http://api.tokobola.loc/images/fotoProfile/' . $Model->foto_profile->original;
        }
        $Model->save();

        Json::set('data', 'successfully update data');
        return response()->json(Json::get(), 201);

    }

    public function updatecms(Request $request, $id)
    {
        // $Model = $request->Payload->all()['Model'];
        $Model = User::find($id);
        $Model->nama_lengkap = $request->nama_lengkap;
        $Model->email = $request->email;
        $Model->alamat = $request->alamat;
        $Model->username = $request->username;
        $Model->no_hp = $request->no_hp;

        $Model->save();

        Json::set('data', 'successfully update data');
        return response()->json(Json::get(), 201);

    }

    public function delete(Request $request, $id)
    {
        $Model = User::find($id);
        $Model->delete();

        Json::set('data', 'successfully deleted data');
        return response()->json(Json::get(), 201);
    }

}
