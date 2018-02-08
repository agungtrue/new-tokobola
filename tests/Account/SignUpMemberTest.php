<?php

use App\Models\User;

use Webpatser\Uuid\Uuid;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SignUpMemberTest extends TestCase
{
    /** @test **/
    public function memberSignUp()
    {

        $response = $this->call('POST', '/account/member', [
            'email' => 'testmember' . Uuid::generate()->string . '@test.test',
            'password' => 'Testing123'
        ]);
        $this->assertEquals(201, $response->status());
    }
}
