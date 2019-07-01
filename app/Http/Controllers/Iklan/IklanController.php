<?php

namespace App\Http\Controllers\Iklan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Support\Response\Json;
use App\Traits\Browse;

use App\Models\User;
use App\Models\Iklan;
use App\Models\Clubs;
use App\Models\Liga;
use App\Models\Negara;



class IklanController extends Controller
{
    use Browse;

    public function get(Request $request)
    {
      $Iklan = Iklan::with('penjual', 'kategori_produk', 'club')
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

            if (isset($request->ArrQuery->userclub)) {
                if ($request->ArrQuery->userclub === 'my') {
                    $query->where('id_club', $request->user()->id_club);
                } else {
                    $query->where('id_club', $request->ArrQuery->userclub);
                }
            }

            if (isset($request->ArrQuery->id_club)) {
                $query->where('id_club', $request->ArrQuery->id_club);
            }

            if (isset($request->ArrQuery->kategori)) {
                $query->where('id_kategori_produk', $request->ArrQuery->kategori);
            }

            if (isset($request->ArrQuery->search)) {
                    $query->where('id', 'like', '%' . $request->ArrQuery->search . '%')
                          ->orwhere('nama_produk', 'like', '%' . $request->ArrQuery->search . '%');
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

      $Browse = $this->Browse($request, $Iklan, function ($data) {
          return $data;
      });

      Json::set('data', $Browse);
      return response()->json(Json::get(), 200);

    }

    public function create(Request $request)
    {
        $this->Model = $request->Payload->all()['Model'];
        $Iklan = $this->Model->Iklan;
        if (isset($Iklan->gambar_produk)) {
            if ($Iklan->gambar_produk->extension !== 'pdf') {
                Storage::disk('public')->put('/images/produk-iklan-member/' . $Iklan->gambar_produk->original, Storage::disk('temporary')->get($Iklan->gambar_produk->original), 'public');
            }
            $Iklan->gambar_produk = 'http://api.tokobola.loc/images/produk-iklan-member/' . $Iklan->gambar_produk->original;
        }
        $Iklan->save();
        Json::set('data', 'successfully created data');
        return response()->json(Json::get(), 201);
    }

    public function update(Request $request, $id)
    {
        $Model = Produk::find($id);
        $Model->nama_produk = $request->nama_produk;
        $Model->harga_produk = $request->harga_produk;
        $Model->spesifikasi_produk = $request->spesifikasi_produk;
        $Model->save();

        Json::set('data', 'successfully update data');
        return response()->json(Json::get(), 201);

    }

    public function delete(Request $request, $id)
    {
        $Model = Produk::find($id);
        $Model->delete();

        Json::set('data', 'successfully deleted data');
        return response()->json(Json::get(), 201);
    }

}
