<?php

use App\Models\CompanyLoanFormula;

use Illuminate\Database\Seeder;

class CompanyLoanFormulaDefault extends Seeder
{
    protected $formula = null;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->formula = (object)[
            'oncepaid' => (object)[
                'capped' => 10,
                'interest' => 1
            ],
            'installments' => (object)[
                'interest' => 1
            ],
            'default' => true,
            'company_id' => 0
        ];

        if (CompanyLoanFormula::where('default', true)->count() < 1) {
            $CompanyLoanFormula = new CompanyLoanFormula();
            $CompanyLoanFormula->oncepaid = $this->formula->oncepaid;
            $CompanyLoanFormula->installments = $this->formula->installments;
            $CompanyLoanFormula->default = true;
            $CompanyLoanFormula->company_id = $this->formula->company_id;
            $CompanyLoanFormula->save();
        }
    }
}
