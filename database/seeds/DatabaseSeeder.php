<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (config('app.env') === 'testing' || config('app.env') === 'development') {
            // only for testing
            $this->call('MemberForTesting');
        }

        $this->call('CompanyLoanFormulaDefault');
    }
}
