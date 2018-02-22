<?php

namespace App\Http\Controllers\Administrative;

use App\Models\Administrative\Province;
use App\Models\Administrative\Regency;
use App\Models\Administrative\District;
use App\Models\Administrative\Village;

use App\Support\Response\Json;
use App\Http\Controllers\Controller;
use App\Traits\Browse;

use Illuminate\Http\Response;
use Illuminate\Http\Request;

class AdministrativeController extends Controller
{
    use Browse;

    public function provinces(Request $request)
    {
        $request->ArrQuery->takeAll = true;
        $Province = Province::where(function ($query) use($request) {
        });
        $Browse = $this->Browse($request, $Province);
        Json::set('data', $Browse);
        return response()->json(Json::get(), 200);
    }

    public function regencies(Request $request)
    {
        $request->ArrQuery->takeAll = true;
        $Regency = Regency::where(function ($query) use(&$request) {
            if (isset($request->ArrQuery->province)) {
                $request->ArrQuery->takeAll = true;
                $query->where('province_id', $request->ArrQuery->province);
            }
        });
        $Browse = $this->Browse($request, $Regency);
        Json::set('data', $Browse);
        return response()->json(Json::get(), 200);
    }

    public function districts(Request $request)
    {
        $District = District::where(function ($query) use(&$request) {
            if (isset($request->ArrQuery->regency)) {
                $request->ArrQuery->takeAll = true;
                $query->where('regency_id', $request->ArrQuery->regency);
            }
        });
        $Browse = $this->Browse($request, $District);
        Json::set('data', $Browse);
        return response()->json(Json::get(), 200);
    }

    public function villages(Request $request)
    {
        $Village = Village::where(function ($query) use(&$request) {
            if (isset($request->ArrQuery->district)) {
                $request->ArrQuery->takeAll = true;
                $query->where('district_id', $request->ArrQuery->district);
            }
        });
        $Browse = $this->Browse($request, $Village);
        Json::set('data', $Browse);
        return response()->json(Json::get(), 200);
    }
}
