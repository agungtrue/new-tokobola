<?php

namespace App\Http\Controllers\Liga;

use App\Models\Liga;
use App\Models\User;

use App\Support\Response\Json;
use App\Http\Controllers\Controller;
use App\Traits\Browse;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class LigaController extends Controller
{
    use Browse;

    public function get(Request $request)
    {
        // dd('woeks');
        $Liga = Liga::
        where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                if ($request->ArrQuery->id === 'my') {
                    $query->where('id', $request->user()->id);
                } else {
                    $query->where('id', $request->ArrQuery->id);
                }
            }
        });
        $Browse = $this->Browse($request, $Liga, function ($data) {
            return $data;
        });
        Json::set('data', $Browse);
        return response()->json(Json::get(), 200);
    }

    public function create(Request $request)
    {
        $this->Model = $request->Payload->all()['Model'];
        $Liga = $this->Model->Liga;
        $Liga->save();
        Json::set('data', 'successfully created data');
        return response()->json(Json::get(), 201);
    }

    public function update(Request $request, $id)
    {
        $Liga = Liga::find($id);
        $Liga->name =  $request->name;
        $Liga->image =  $request->image;
        $Liga->id_negara =  $request->id_negara;
        $Liga->save();

        Json::set('data', 'successfully update data');
        return response()->json(Json::get(), 201);

    }

    public function delete(Request $request, $id)
    {
        $Model = Liga::find($id);
        $Model->delete();

        Json::set('data', 'successfully deleted data');
        return response()->json(Json::get(), 201);
    }
}
