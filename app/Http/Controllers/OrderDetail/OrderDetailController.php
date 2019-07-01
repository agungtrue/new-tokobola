<?php

namespace App\Http\Controllers\OrderDetail;

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
use App\Models\OrderDetail;



class OrderDetailController extends Controller
{
    use Browse;

    public function get(Request $request)
    {
      $Order= OrderDetail::with('produk')
      ->where(function ($query) use($request) {

            if (isset($request->ArrQuery->member_id)) {
                $query->where('member_id', $request->ArrQuery->id);
            }

            if (isset($request->ArrQuery->id)) {
                $query->where('order_id', $request->ArrQuery->id);
            }

            if (isset($request->ArrQuery->order_my)) {
                if ($request->ArrQuery->order_my === 'my') {
                    $query->where('member_id', $request->user()->id);
                } else {
                    $query->where('member_id', $request->ArrQuery->id);
                }
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

      $Browse = $this->Browse($request, $Order, function ($data) {
          return $data;
      });

      Json::set('data', $Browse);
      return response()->json(Json::get(), 200);

    }

    public function create(Request $request)
    {
        $this->Model = $request->Payload->all()['Model'];

        //bikin array kosong untuk menampung data order
        $orderDetail = [];

        //decode data yg berisikan banyaknya id dari table keranjang
        $arrayofkeranjang_id = json_decode($this->Model->Order->keranjang_id);

        //hapus keranjang_id dari Model Order
        unset($this->Model->Order->keranjang_id);

        //bikin variable untuk menampung total dari harga dan qty
        $totalHarga = 0;
        $totalQty = 0;

        //looping data yg berisikan keranjang_id
        foreach ($arrayofkeranjang_id as $key => $value) {

          //temukan keranjang_id dari table keranjang
          $keranjang = Keranjang::find($value);

          $totalQty += $keranjang['jumlah'];
          $totalHarga += $keranjang['total_harga_produk'];

          //masukan data yg sudah di looping, kedalam array baru
          $data = array();
          $data['produk_id'] = $keranjang['produk_id'];
          $data['harga_produk'] = $keranjang['harga_produk'];
          $data['qty'] = $keranjang['jumlah'];
          $data['keterangan'] = $keranjang['keterangan'];

          //masukan array tersebut kedalam variable $orderDetail
          array_push($orderDetail, $data);
        }


        //masukan data yg sudah diolah kedalam model order
        $this->Model->Order->jumlah_barang = $totalQty;
        $this->Model->Order->total_harga_pesanan = $totalHarga;
        $this->Model->Order->save();

        //hapus keranjang_id yang digunakan untuk melakukan orders
        foreach ($arrayofkeranjang_id as $key => $value) {

          //temukan keranjang_id dari table keranjang
          $keranjang = Keranjang::find($value);
          $keranjang->delete();
        }

        //ambil order_id yg akan di proses dan buat key baru dengan nama 'order_id' ke dalam variable
        //$orderDetail
        $order_id = $this->Model->Order->order_id;
        foreach ($orderDetail as $key => $value) {

          //masukan value dari var $order_id kedalam table order detail['order_id']
          $orderDetail[$key]['order_id'] = $order_id;
        }

        //lakukan bluck insert ke table order detail
        OrderDetail::insert($orderDetail);

        Json::set('data', 'successfully created data');
        return response()->json(Json::get(), 201);
    }

    public function update(Request $request, $id)
    {
        $Model = Order::find($id);
        $Model->status = $request->status;
        $Model->save();

        Json::set('data', 'successfully update data');
        return response()->json(Json::get(), 201);

    }

    public function delete(Request $request, $id)
    {
        $Model = Blog::find($id);
        $Model->delete();

        Json::set('data', 'successfully deleted data');
        return response()->json(Json::get(), 201);
    }

}
