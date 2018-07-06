<?php

use App\Models\User;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class LoanTest extends TestCase
{
    /** @test **/
    public function loanOncePaid()
    {
        $user = User::where('email', 'memberone@test.test')->first();
        $this->actingAs($user, 'api');

        $response = $this->call('POST', '/loan', [
            'loan_amount' => 3000000,
            'term' => '1',
            'term_type' => 'oncepaid',
            'reason' => 'Karena butuh uang'
        ]);
        $this->assertEquals(201, 201);
    }

    /** @test **/
    public function loanOnceInstallments()
    {
        $user = User::where('email', 'memberone@test.test')->first();
        $this->actingAs($user, 'api');

        $response = $this->call('POST', '/loan', [
            'loan_amount' => 3000000,
            'term' => '2',
            'term_type' => 'installments',
            'reason' => 'Karena butuh uang'
        ]);
        $this->assertEquals(201, 201);
    }
}
