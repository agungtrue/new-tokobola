<?php

namespace App\Http\Controllers\Produk;

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



class ProdukController extends Controller
{
    use Browse;

    public function get(Request $request)
    {
      // dd('wpeils');
      $Produk = Produk::with('penjual', 'kategori_produk', 'club')
      ->where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where('id', $request->ArrQuery->id);
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

      $Browse = $this->Browse($request, $Produk, function ($data) {
          return $data;
      });

      Json::set('data', $Browse);
      return response()->json(Json::get(), 200);

    }

    public function create(Request $request)
    {
        $this->Model = $request->Payload->all()['Model'];
        $Produk = $this->Model->Produk;
        if (isset($Produk->images)) {
            if ($Produk->images !== 'pdf') {
                Storage::disk('public')->put('/images/produk-tokobola/' . $Produk->images->original, Storage::disk('temporary')->get($Produk->images->original), 'public');
            }
            $Produk->images = 'http://api.tokobola.loc/images/produk-tokobola/' . $Produk->images->original;
        }
        $Produk->save();
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
