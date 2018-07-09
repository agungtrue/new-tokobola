<?php

use App\Models\User;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class LoginTest extends TestCase
{
    /** @test **/
    public function login()
    {
        $response = $this->call('POST', '/login', [
            'email' => 'memberone@test.test',
            'password' => 'Testing123'
        ]);
        $this->assertEquals(201, $response->status());
    }
}
