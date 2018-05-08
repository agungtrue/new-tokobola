<?php

namespace App\Traits;

use App\Models\Company as CompanyModel;

use App\Support\Generate\Hash;

trait Company
{
    public function GenerateCompanyKey()
    {
        $key = Hash::Random(null, 7);
        if (CompanyModel::where('key', $key)->first()) {
            return $this->GenerateCompanyKey();
        }
        return $key;
    }
}
