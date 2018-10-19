<?php

namespace App\Http\Controllers\Negara;

use App\Models\Negara;
use App\Models\User;

use App\Support\Response\Json;
use App\Http\Controllers\Controller;
use App\Traits\Browse;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class NegaraController extends Controller
{
    use Browse;

    public function get(Request $request)
    {
        // dd('woeks');
        $Negara = Negara::
        where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                if ($request->ArrQuery->id === 'my') {
                    $query->where('id', $request->user()->id);
                } else {
                    $query->where('id', $request->ArrQuery->id);
                }
            }
        });
        $Browse = $this->Browse($request, $Negara, function ($data) {
            return $data;
        });
        Json::set('data', $Browse);
        return response()->json(Json::get(), 200);
    }

    public function create(Request $request)
    {
        $this->Model = $request->Payload->all()['Model'];
        $Club = $this->Model->Club;
        $Club->save();
        Json::set('data', 'successfully created data');
        return response()->json(Json::get(), 201);
    }

    public function update(Request $request, $id)
    {
        $Club = Clubs::find($id);
        $Club->name =  $request->name;
        $Club->image =  $request->image;
        $Club->id_liga =  $request->id_liga;
        $Club->save();

        Json::set('data', 'successfully update data');
        return response()->json(Json::get(), 201);

    }

    public function delete(Request $request, $id)
    {
        $Model = Clubs::find($id);
        $Model->delete();

        Json::set('data', 'successfully deleted data');
        return response()->json(Json::get(), 201);
    }
}
