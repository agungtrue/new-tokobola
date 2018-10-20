<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\Controller;
use App\Support\Response\Json;
use App\Traits\Browse;

use App\Models\User;
use App\Models\Produk;
use App\Models\Clubs;
use App\Models\Liga;
use App\Models\Negara;
use App\Models\Order;



class OrderController extends Controller
{
    use Browse;

    public function get(Request $request)
    {
      $Order= Order::with('produk')
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
        $Order = $this->Model->Order;
        $Order->save();
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
