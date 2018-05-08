<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class CompanyLoanFormula extends Eloquent {
    protected $connection = 'collection_systems';
    protected $collection = 'company_loan_formula';
    protected $dates = ['created_at', 'updated_at'];

}
