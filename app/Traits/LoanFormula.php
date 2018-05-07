<?php

namespace App\Traits;

use App\Models\CompanyLoanFormula;

use App\Support\Generate\Hash;

trait LoanFormula
{
    private $month = 30;

    public function interest($principal, $term, $type = 'oncepaid')
    {
        $companyId = [];
        $Formula = (object)[];
        $Company = $this->request->user()->member->company;

        if ($Company) {
            $companyId[] = $Company->id;
        }

        $FormulaCollection = CompanyLoanFormula::whereIn('company_id', $companyId)
        ->orWhere('default', true)
        ->get()
        ->keyBy('company_id');

        if ($Company) {
            $Formula = $FormulaCollection[$Company->id];
        } else {
            $Formula = $FormulaCollection[0];
        }

        return $this->calculateInterest($Formula, $principal, $term, $type);
    }

    public function calculateInterest($Formula, $principal, $term, $type)
    {
        if ($type === 'oncepaid') {
            $percentage = $term * $Formula->oncepaid['interest'];
            if (isset($Formula->oncepaid['capped']) && $percentage > $Formula->oncepaid['capped']) {
                $percentage = $Formula->oncepaid['capped'];
            }
        }
        if ($type === 'installments') {
            $percentage = $term * $Formula->installments['interest'];
            if (isset($Formula->oncepaid['capped']) && $percentage > $Formula->oncepaid['capped']) {
                $termInMonth = $term / $this->month;
                $percentage = $Formula->oncepaid['capped'] * round($termInMonth);
            }
        }
        return ($principal * $percentage) / 100;
    }
}
