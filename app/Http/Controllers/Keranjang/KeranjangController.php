<?php

namespace App\Http\Controllers\Keranjang;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\Controller;
use App\Support\Response\Json;
use App\Traits\Browse;

use App\Models\User;
use App\Models\Produk;
use App\Models\Order;
use App\Models\Keranjang;




class KeranjangController extends Controller
{
    use Browse;

    public function get(Request $request)
    {
      $Keranjang= Keranjang::with('produk', 'member')
      // ->where('member_id', $request->user()->id);
      ->where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where('id', $request->ArrQuery->id);
            }

            if (isset($request->ArrQuery->kerjanjang_my)) {
                if ($request->ArrQuery->kerjanjang_my === 'my') {
                    $query->where('member_id', $request->user()->id);
                } else {
                    $query->where('member_id', $request->ArrQuery->id);
                }
            }
        });


      $Browse = $this->Browse($request, $Keranjang, function ($data) {
          return $data;
      });

      Json::set('data', $Browse);
      return response()->json(Json::get(), 200);

    }

    public function create(Request $request)
    {
        $this->Model = $request->Payload->all()['Model'];
        $Keranjang = $this->Model->Keranjang;
        $Keranjang->save();
        Json::set('data', $Keranjang);
        return response()->json(Json::get(), 201);
    }

    public function update(Request $request, $id)
    {
        $Model = Keranjang::find($id);
        $Model->jumlah = $request->jumlah;
        $Model->keterangan = $request->keterangan;
        $Model->total_harga_produk = $Model->harga_produk * $Model->jumlah;
        $Model->save();

        Json::set('data', 'successfully update data');
        return response()->json(Json::get(), 201);

    }

    public function delete(Request $request, $id)
    {
        $Model = Keranjang::find($id);
        $Model->delete();

        Json::set('data', 'successfully deleted data');
        return response()->json(Json::get(), 201);
    }

}
