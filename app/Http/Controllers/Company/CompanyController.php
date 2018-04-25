<?php

namespace App\Http\Controllers\Company;

use App\Models\Company;
use App\Models\CompanyLoanFormula;

use App\Traits\Browse;
use App\Traits\Company as CompanyTrait;

use App\Support\Response\Json;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    use Browse, CompanyTrait;

    public function get(Request $request)
    {
        $Company = Company::
        where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                if ($request->ArrQuery->id === 'my') {
                    $query->where('id', $request->user()->id);
                } else {
                    $query->where('id', $request->ArrQuery->id);
                }
            }
            if (isset($request->ArrQuery->key)) {
                $query->where('key', $request->ArrQuery->key);
            }
        });
        $Browse = $this->Browse($request, $Company, function ($data) {
            $companyId = $data->pluck('id');

            $Formula = CompanyLoanFormula::
                whereIn('company_id', $companyId)
                ->orWhere('default', true)
                ->get()
                ->keyBy('company_id');

            $data->map(function($item) use ($Formula) {
                if (isset($Formula[$item->id])) {
                    $item->loan_formula = $Formula[$item->id];
                } else {
                    $item->loan_formula = isset($Formula[0]) ? $Formula[0] : null;
                }
                return $item;
            });
            return $data;
        });
        Json::set('data', $Browse);
        return response()->json(Json::get(), 200);
    }

    public function create(Request $request)
    {
        $this->Model = $request->Payload->all()['Model'];
        $Company = $this->Model->Company;
        $Company->key = $this->GenerateCompanyKey();
        $Company->save();
        Json::set('data', $Company);
        return response()->json(Json::get(), 201);
    }

    public function update(Request $request)
    {
        echo 'update';
    }

    public function updateMy(Request $request)
    {
        return response()->json(Json::get(), 201);
    }

    public function delete(Request $request)
    {
        echo 'delete';
    }
}
