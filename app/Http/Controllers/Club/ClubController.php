<?php

namespace App\Http\Controllers\Club;

use App\Models\Clubs;
use App\Models\User;

use App\Support\Response\Json;
use App\Http\Controllers\Controller;
use App\Traits\Browse;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ClubController extends Controller
{
    use Browse;

    public function get(Request $request)
    {
        // dd('woeks');
        $Club = Clubs::
        where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                if ($request->ArrQuery->id === 'my') {
                    $query->where('id', $request->user()->id);
                } else {
                    $query->where('id', $request->ArrQuery->id);
                }
            }
            if (isset($request->ArrQuery->liga)) {
                $request->ArrQuery->takeAll = true;
                $query->where('id_liga', $request->ArrQuery->liga);
            }
            if (isset($request->ArrQuery->search)) {
                    $query->where('name', 'like', '%' . $request->ArrQuery->search . '%');
            }
        });
        $Browse = $this->Browse($request, $Club, function ($data) {
            return $data;
        });
        Json::set('data', $Browse);
        return response()->json(Json::get(), 200);
    }

    public function create(Request $request)
    {
        $this->Model = $request->Payload->all()['Model'];
        $Club = $this->Model->Club;
        if (isset($Club->image)) {
            if ($Club->image !== 'pdf') {
                Storage::disk('public')->put('/images/club/' . $Club->image->original, Storage::disk('temporary')->get($Club->image->original), 'public');
            }
            $Club->image = 'http://api.tokobola.loc/images/club/' . $Club->image->original;
        }
        $Club->save();
        Json::set('data', $Club);
        return response()->json(Json::get(), 201);
    }

    public function update(Request $request, $id)
    {
        $Club = Clubs::find($id);
        $Club->name =  $request->name;
        // $Club->id_liga =  $request->id_liga;
        $Club->image =  $request->image ? json_decode($request->image) : null;

        if (isset($Club->image)) {
            if ($Club->image->extension !== 'pdf') {
                Storage::disk('public')->put('/images/club/' . $Club->image->original, Storage::disk('temporary')->get($Club->image->original), 'public');
            }
            $Club->image = 'http://api.tokobola.loc/images/club/' . $Club->image->original;
        }

        $Club->save();

        Json::set('data', $Club);
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
